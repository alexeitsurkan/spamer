<?php namespace app\modules\anecdote\components\parsers;

use app\modules\anecdote\models\Entity\Anecdote;

/**
 * Class AnecdoteParse
 * @package app\components\parsers
 */
class AnecdoteParse extends AbstractParse
{
    public function execute(): void
    {
        ini_set('memory_limit', '-1');

        $url_list = $this->getAnecdoteUrl();
        foreach ($url_list as $url) {
            $this->iterateAnecdote($url);
        }
    }

    /**
     * @return array
     */
    protected function getAnecdoteUrl(): array
    {
        $href_list = [];
        $page_url  = 'https://mixnews.lv/anekdoty/';
        do {
            $xpath   = $this->getXpath($page_url);
            $entries = $xpath->evaluate(
                '//div[@class=\'col-lg-12 col-md-12 col-sm-12 mixer-post-container one-posts\']//h2//a'
            );
            foreach ($entries as $entry) {
                $href_list[] = $entry->attributes->getNamedItem('href')->value;
            }

            $entries = $xpath->evaluate('//a[@class="next page-numbers"]');
            if ($entries[0]) {
                $page_url = $entries[0]->attributes->getNamedItem('href')->value;
            } else {
                break;
            }
        } while (true);

        return $href_list;
    }

    /**
     * @param $url
     */
    protected function iterateAnecdote($url)
    {
        $xpath   = $this->getXpath($url);
        $entries = $xpath->evaluate('//*[@class="blog-post"]/div[@class="entry-content"]/p');

        foreach ($entries as $entry) {
            if (mb_strlen($entry->nodeValue) > 4) {
                $this->save($entry->nodeValue);
            }
        }
    }

    /**
     * @param $anecdote
     * @return bool
     */
    protected function save($anecdote): bool
    {
        $model       = new Anecdote();
        $model->text = $anecdote;
        return $model->save();
    }
}
