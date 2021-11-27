<?php namespace app\modules\anecdote\components\parsers;

use app\modules\anecdote\models\Entity\PlohiePesni;

/**
 * Class PlohiePesniParse
 * @package app\components\parsers
 */
class PlohiePesniParse extends AbstractParse
{
    public function execute(): void
    {
        ini_set('memory_limit', '-1');

        $xpath   = $this->getXpath('https://humorpedia.ru/plohie-pesni-text.html');
        $entries = $xpath->evaluate('//div//table//td[@width="330"]');

        foreach ($entries as $entry) {
            if (trim($entry->nodeValue) != 'Текст песни') {
                $this->save(trim($entry->nodeValue));
            }
        }
    }

    /**
     * @param $anecdote
     * @return bool
     */
    protected function save($anecdote): bool
    {
        $model       = new PlohiePesni();
        $model->text = $anecdote;
        return $model->save();
    }
}
