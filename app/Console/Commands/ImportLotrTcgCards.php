<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\CardCulture;
use App\Models\CardRarity;
use App\Models\CardVariant;
use App\Models\Game;
use App\Models\Series;
use Goutte;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ImportLotrTcgCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:lotr-tcg:cards
    {--S|series : Choose the series you want to import}
    {--I|image : Overwrite existing image}
    {--T|tengwar : Only import tengwar cards}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import LOTR cards from wiki.';

    private string $base_url = 'https://lotrtcgwiki.com/';
    private ?Game $game = null;
    private bool $overwrite_image = false;
    private bool $only_tengwar = false;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->game            = Game::find(1);
        $series                = $this->option('series');
        $this->overwrite_image = $this->option('image');
        $this->only_tengwar    = $this->option('tengwar');
        $crawler               = Goutte::request('GET', $this->base_url . 'wiki/grand');
        $series_items          = Series::orderBy('set_number')->get();
        $series_choice         = null;

        if ($series) {
            $series_choice = $this->choice("Choose your series", $series_items->pluck('set_number')->toArray());
        }

        if ($series_choice != null) {
            $this->info("Processing series: " . $series_items->where('set_number', $series_choice)->first()->name);
        }

        $crawler->filter('.level1 table.inline tr:not(.row0)')->each(function (Crawler $node) use ($series_choice) {
            $card_info_node = $node->filter('td.col0')->first();

            if (!$card_info_node) {
                return true;
            }

            $matches = $this->parseCardInfo($card_info_node);

            if (count($matches) < 2) {
                return true;
            }

            if (!isset($series_choice)) {
                $this->parseRow($node);
            } else if ($series_choice == $matches[1]) {
                $this->parseRow($node);
            }

            return true;
        });

        $this->info("Finished processing series: " . $series_items->where('set_number', $series_choice)->first()->name);

        return 0;
    }

    private function parseRow(Crawler $row): void
    {
        $link_cell    = $row->filter('td.col1 a')->first();
        $info_cell    = $row->filter('td.col0')->first();
        $culture_cell = $row->filter('td.col3 a')->first();

        if (!$link_cell || !$info_cell || !$culture_cell) {
            return;
        }

        $info_details = $this->parseCardInfo($info_cell);
        $series       = Series::whereSetNumber($info_details[1])->first();
        $is_tengwar   = $info_details[4] == 'T';

        if ($this->only_tengwar && !$is_tengwar) {
            return;
        }

        if (!$series) {
            return;
        }

        $this->info("Importing: " . $link_cell->text());

        $card_number = $info_details[3];

        if (!is_null($card_number) && strlen($card_number) < 1) {
            $card_number = null;
        }

        # Card relationships
        $rarity  = $this->getCardRarity(strtoupper($info_details[2]));
        $culture = CardCulture::whereName($culture_cell->text())->first();
        $card    = Card::forSeries($series)
                       ->forRarity($rarity)
                       ->whereCardNumber($card_number)
                       ->first();

        # Card details crawler
        $href             = $link_cell->attr('href');
        $card_details_url = $this->base_url . $href;
        $crawler          = Goutte::request('GET', $card_details_url);

        if ($is_tengwar) {
            if (is_null($card)) {
                return;
            }

            $data = [
                'name'        => $link_cell->text(),
                'description' => 'Tengwar'
            ];

            $variant = $card->variants()->tengwar()->first();

            if (!$variant) {
                $variant = CardVariant::make($data);
                $variant->card()
                        ->associate($card)
                        ->save();

                $this->getCardImage($variant, $crawler);
            }
        } else {
            $data = [
                'title'       => $link_cell->text(),
                'card_number' => $card_number,
            ];

            if (!$card) {
                $card = Card::make($data);
            } else {
                $card->fill($data);
            }

            $card->series()->associate($series);
            $card->rarity()->associate($rarity);
            $card->culture()->associate($culture);
            $card->save();

            $this->getCardSpecificDetails($card, $crawler);
        }
    }

    private function getCardSpecificDetails(Model $model, Crawler $crawler)
    {
        $this->getCardImage($model, $crawler);
        $this->getCardStats($model, $crawler);
    }

    public function getCardImage(Model $model, Crawler $crawler)
    {
        $image_el = $crawler->filter('.level1 .plugin_wrap span.curid a.media img.media')->first();

        if ($image_el) {
            $this->importCardImage($model, $image_el);
        }
    }

    public function getCardStats(Card $card, Crawler $crawler)
    {
        $details_table = $crawler->filter('.level1 .wrap_db2 .table table')->first();

        if ($details_table) {
            $this->importCardStats($card, $details_table);
        }
    }

    private function importCardStats(Card $card, Crawler $table)
    {
        $table->filter('tr')->each(function (Crawler $row) use ($card) {
            $cell0 = $row->filter('td.col0 a')->first();
            $cell1 = $row->filter('td.col1')->first();

            if (!$cell0->count() || !$cell1->count()) {
                return true;
            }

            if ($cell0->text() == 'Game Text') {
                $card->game_text = $cell1->text();
            } else if ($cell0->text() == 'Lore') {
                $card->lore = $cell1->text();
            } else if ($cell0->text() == 'Card Type') {
                $type_tree     = $cell1->text();
                $parts         = explode('•', $type_tree, 2);
                $card->type    = trim($parts[0] ?? null);
                $card->subtype = trim($parts[1] ?? null);
            }

            return true;
        });

        $card->save();
    }

    private function importCardImage(Model $model, Crawler $image_el): void
    {
        $uri = $image_el->attr('src');

        if (Str::endsWith($uri, '/')) {
            $uri = ltrim($uri, '/');
        }

        $url = $this->base_url . $uri;

        if ($model->hasMedia('primary') && $this->overwrite_image) {
            $this->info("> Deleting existing card image");
            $model->deleteMedia($model->getFirstMedia('primary')->id);

            $model->refresh();
        }

        if (!$model->hasMedia('primary')) {
            $this->info("> Importing card image");
            $model->addMediaFromUrl($url)->toMediaCollection('primary');
        }
    }

    private function parseCardInfo(Crawler $node): array
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

        if (!$rarity) {
            $rarity = CardRarity::make([
                'name' => $name
            ]);

            $rarity->game()->associate($this->game);
            $rarity->save();
        }

        return $rarity;
    }
}
