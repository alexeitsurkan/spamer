<?php namespace app\modules\citaty\components\parsers;

use app\components\AbstractParse;
use app\modules\citaty\models\Entity\Citaty;

/**
 * Class CitatyParse
 * @package app\modules\citaty\components\parsers
 */
class CitatyParse extends AbstractParse
{
    public function execute(): void
    {
        ini_set('memory_limit', '-1');

        $xpath   = $this->getXpath('https://citaty.info/topic');
        $entries = $xpath->evaluate('//div[@class="term-name field-type-entityreference"]/a');

        foreach ($entries as $entry) {
            $topic_name = $entry->nodeValue;
            $topic_href = $entry->attributes->getNamedItem('href')->value;
            $this->getByTopic($topic_name, $topic_href);
        }
    }

    protected function getByTopic($topic_name, $topic_href)
    {
        do {
            $xpath   = $this->getXpath($topic_href);
            $entries = $xpath->evaluate('//div[@class="node__content"]');
            foreach ($entries as $entry) {
                $data =[];
                foreach ($entry->childNodes as $child){
                    $str = trim($child->nodeValue);
                    $str = preg_replace('/[\s]{2,}/',' ',$str);
                    $str = preg_replace('/\n/','',$str);
                    $str = preg_replace('/Пояснение к цитате:.*/','',$str);
                    if(!empty($str) && $str != 'Цитата на английском') $data[] = $str;
                }
                $text = array_shift($data);
                array_pop($data);


                try{
                    $model         = new Citaty();
                    $model->text   = $text;
                    $model->info = implode(', ', $data);
                    $model->theme  = $topic_name;
                    $model->save();
                }catch (\Exception $e) {

                }

            }
            $entries = $xpath->evaluate('//ul[@class="pager pager-regular"]/li[@class="pager-item pager-next last"]/a');
            if ($entries[0]) {
                $topic_href = $entries[0]->attributes->getNamedItem('href')->value;
            } else {
                break;
            }
        } while (true);
    }
}
