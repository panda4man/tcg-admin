<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\CardCulture;
use App\Models\CardRarity;
use App\Models\Game;
use App\Models\Series;
use Goutte;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ImportLotrTcgCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:lotr-tcg:cards
    {--S|series= : Choose the series you want to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import LOTR cards from wiki.';

    private string $base_url = 'https://lotrtcgwiki.com/';
    private ?Game $game = null;

    public function __construct()
    {
        parent::__construct();

        $this->game = Game::find(1);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $series  = $this->option('series');
        $crawler = Goutte::request('GET', $this->base_url . 'wiki/grand');

        $crawler->filter('.level1 table.inline tr:not(.row0)')->each(function (Crawler $node) use ($series) {
            $card_info_node = $node->filter('td.col0')->first();

            if (!$card_info_node) {
                return true;
            }

            $matches = $this->parseCardInfo($card_info_node);

            if (count($matches) < 2) {
                return true;
            }

            if (!isset($series)) {
                $this->parseRow($node);
            } else if ($series === $matches[1]) {
                $this->parseRow($node);
            }

            return true;
        });

        return 0;
    }

    private function parseRow(Crawler $row): void
    {
        $link_cell = $row->filter('td.col1 a')->first();
        $info_cell = $row->filter('td.col0')->first();
        $culture_cell = $row->filter('td.col3 a')->first();

        if (!$link_cell || !$info_cell || !$culture_cell) {
            return;
        }

        $info_details = $this->parseCardInfo($info_cell);
        $series       = Series::whereSetNumber($info_details[1])->first();

        if (!$series) {
            return;
        }

        $card_number = $info_details[3];
        $rarity      = $this->getCardRarity(strtoupper($info_details[2]));
        $culture = CardCulture::whereName($culture_cell->text())->first();
        $card        = Card::forSeries($series)->whereCardNumber($card_number)->first();

        $data = [
            'title'       => $link_cell->text(),
            'card_number' => $card_number,
        ];
        dd($data, $rarity, $culture_cell->text());

        if (!$card) {
            $card = Card::make($data);
        } else {
            $card->fill($data);
        }

        $card->series()->associate($series);
        $card->rarity()->associate($rarity);
        $card->culture()->associate($culture);
        $card->save();

        $href             = $link_cell->attr('href');
        $card_details_url = $this->base_url . $href;
        //$crawler          = Goutte::request('GET', $card_details_url);

    }

    private function parseCardInfo(Crawler $node)
    {
        $card_info = $node->text();
        $regex     = "/(\d+)([RUCPSAFDWMPO\+]+)(\d+)?(T?)/";
        preg_match($regex, $card_info, $matches);

        return $matches ?? [];
    }

    private function getCardRarity(string $name): CardRarity
    {
        $rarity = CardRarity::firstWhere([
            'name' => $name
        ]);

        if(!$rarity) {
            $rarity = CardRarity::make([
                'name' => $name
            ]);

            $rarity->game()->associate($this->game);
            $rarity->save();
        }

        return $rarity;
    }
}
