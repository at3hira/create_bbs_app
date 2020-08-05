<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade as GoutteFacade;
use Redis;


class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scrapecommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save scraped data to redis using Goutte';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
		* Goutteを使ってYahooトップニュースをスクレイピング
		*/ 
		$news_link = array();
		$news_list = array();
		$goutte = GoutteFacade::request('GET', 'https://news.yahoo.co.jp/');
		$goutte->filter('.topicsListItem ')->each(function ($node) use (&$news_list, &$news_link) {
			$news_link[] = $node->filter('a')->attr('href');
			$news_list[] = $node->text();
		});

        // 取得したデータをredisへ保存
		Redis::command('set', ['news_list', json_encode($news_list)]);
		Redis::command('set', ['news_link', json_encode($news_link)]);
    }
}
