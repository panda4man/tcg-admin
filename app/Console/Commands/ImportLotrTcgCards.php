<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\CardRarity;
use App\Models\Series;
use Goutte;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ImportLotrTcgCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:lotr-tcg
    {--S|update-series-image : Update series image}
    {--C|choose : Choose which series to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import LOTR TCG Card Set';

    private $series_map = [
        'Fellowship of the Ring'  => '34_39',
        'Mines of Moria'          => '34_40',
        'Realms of the Elf-lords' => '34_41',
        'The Two Towers'          => '34_42',
        'Battle of Helm\'s Deep'  => '34_43',
        'Ends of Fangorn'         => '34_44',
        'Return of the King'      => '34_45',
        'Siege of Gondor'         => '34_46',
        'Reflections'             => '34_47',
        'Mount Doom'              => '34_48',
        'Shadows'                 => '34_49',
        'Black Rider'             => '34_50',
        'Bloodlines'              => '34_51',
        'Expanded Middle-earth'   => '34_52',
        'The Hunters'             => '34_53',
        'The Wraith Collection'   => '34_54',
        'Rise of Saruman'         => '34_55',
        'Treachery and Deceit'    => '34_56',
        'Ages End'                => '34_57',
    ];

    private $base_url = 'https://www.ccg-singles.com/';

    public function handle(): int
    {
        $update_series_image = $this->option('update-series-image');
        $choose              = $this->option('choose');

        if ($choose) {
            $choice = $this->choice('Which series?', array_keys($this->series_map));
        }

        foreach ($this->series_map as $key => $value) {
            if (isset($choice) && $choice != $key) {
                continue;
            }

            $this->info("> Processing $key");
            $series = Series::whereName($key)->first();

            if (!$series) {
                $this->error("Could not find a local series for [$key]");
                continue;
            }

            $params  = [
                'main_page' => 'index',
                'cPath'     => $value
            ];
            $url     = sprintf("%sindex.php?%s", $this->base_url, http_build_query($params));
            $crawler = Goutte::request('GET', $url);

            if ($update_series_image) {
                $this->updateSeriesImage($series, $crawler);
            }

            $crawler->filter("#productListing #cat{$value}Table tr:not(.productListing-rowheading)")->each(function (Crawler $node) use ($series) {
                $product_name_node = $node->filter('td')->eq(2);
                $product_name      = $product_name_node->filter('a')->first()->text();

                if (Str::contains($product_name, 'Booster Pack')) {
                    # Skip booster pack line
                    return true;
                }

                $detail_link = $node->filter('td')->eq(1)->filter('a')->first();
                $detail_page = Goutte::request('GET', $detail_link->attr('href'));

                $this->handleCard($series, $detail_page);

                return true;
            });
        }

        return 0;
    }

    private function handleCard(Series $series, Crawler $page): void
    {
        $product_name        = $page->filter('#productName')->first()->text();
        $product_desc_ele    = $page->filter('#productDescription');
        $product_description = $product_desc_ele->count() ? $product_desc_ele->first()->text() : null;
        $title               = trim(collect(explode('-', $product_name, 2))->values()->get(1));
        $this->info("> Importing: " . $product_name);
        $regex = "/(\d+)([RUCPS])(\d+)(T?)/";
        preg_match($regex, $product_name, $matches);
        //print_r($matches);

        if (!count($matches) > 1) {
            return;
        }

        $card_tengwar = $matches[4];
        $card_number  = $matches[3];
        $card_rarity  = strtoupper($matches[2]);

        if ($card_tengwar) {
            return;
        }

        $rarity         = CardRarity::whereName($card_rarity)->first();
        $card_image_url = $this->getCardImage($page);
        $card           = Card::forSeries($series)->whereCardNumber($card_number)->first();

        $data = [
            'title'       => $title,
            'card_number' => $card_number,
            'game_text'   => $product_description
        ];

        if (!$card) {
            $card = Card::make($data);
        } else {
            $card->fill($data);
        }

        $card->series()->associate($series);
        $card->rarity()->associate($rarity);
        $card->save();

        if ($card_image_url && !$card->hasMedia('primary')) {
            $card->addMediaFromUrl($card_image_url)->toMediaCollection('primary');
        }
    }

    private function getCardImage(Crawler $crawler): ?string
    {
        $product_image_link = $crawler->filter('#productMainImage a')->first();
        $href               = $product_image_link->attr('href');
        //don't need this i guess?
//        $regex              = '/javascript:popupWindow\(\'([^,]+)\'\)/';
//        preg_match($regex, $href, $matches);
//
//        if (count($matches) < 2) {
//            return null;
//        }

        $card_image_crawler = Goutte::request('GET', $href);
        $image_element      = $card_image_crawler->filter('#popupImage img')->first();

        if (!$image_element) {
            return null;
        }

        return sprintf("%s/%s", $this->base_url, $image_element->attr('src'));
    }

    private function updateSeriesImage(Series $series, Crawler $page): void
    {
        $node = $page->filter('#categoryImgListing > img')->first();

        if ($node) {
            $this->info("> Found a series image. Updating...");
            $uri        = $node->attr('src');
            $image_path = sprintf("%s/%s", $this->base_url, $uri);

            if ($series->getMedia('primary')->count()) {
                $series->deleteMedia('primary');
            }

            $series->addMediaFromUrl($image_path)->toMediaCollection('primary');

            $this->info("> Updated series image");
        }
    }
}
