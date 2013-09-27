<?php
///**
// * Created by JetBrains PhpStorm.
// * User: d.sukhov
// * Date: 08.08.13
// * Time: 17:28
// * To change this template use File | Settings | File Templates.
// */
//set_time_limit(0);
//
////алгоритм создания массива с данными таблицы для выгрузки в файлы
//$phrases = Translations::model()->findAll();
///** @var Translations $phrase*/
//$phraseAll = array();
//foreach ($phrases as $phrase){
//    $phraseAll['ar'][$phrase->Category][$phrase->Key] = $phrase->LangAr;
//    $phraseAll['az'][$phrase->Category][$phrase->Key] = $phrase->LangAz;
//    $phraseAll['en'][$phrase->Category][$phrase->Key] = $phrase->LangEn;
//    $phraseAll['es'][$phrase->Category][$phrase->Key] = $phrase->LangEs;
//    $phraseAll['zh_cn'][$phrase->Category][$phrase->Key] = $phrase->LangCn;
//    $phraseAll['my'][$phrase->Category][$phrase->Key] = $phrase->LangMy;
//    $phraseAll['id'][$phrase->Category][$phrase->Key] = $phrase->LangId;
//    $phraseAll['ru'][$phrase->Category][$phrase->Key] = $phrase->LangRu;
//
//}
//
////$phraseAll - готовый массив для отправки
//
////выгрузка массива в файлы
//$path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'fromdb'.DIRECTORY_SEPARATOR;
//
//$arrayForFile = array();
//
//foreach ($phraseAll as $lang => $categories) {
//    foreach($categories as $category => $keys){
//        foreach($keys as $key => $phrase){
//            $data = '"'.$key.'" => "'.$phrase.'"';
//            $arrayForFile[$lang][$category][] =  $data;
//        }
//    }
//}
//foreach ($arrayForFile as $lang => $categories){
//    foreach($categories as $category => $phrase){
//        $fp = fopen($path.$lang.DIRECTORY_SEPARATOR.$category.".php", "w");
//        $text = "<?php\nreturn array(\n    ".implode(",\n  ",$phrase)."\n);";
//        fwrite($fp, $text);
//        fclose($fp);
//    }
//}
//
//echo "done!\n";
//
//
//
//die;
//
////выгрузка из файла в массив и запись обратно
//$path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'fromdb'.DIRECTORY_SEPARATOR;
//
//$test = require($path.'file.php');
//
//$arrayForFile = array();
//foreach ($test as $key => $phrase){
//    $data = "'$key' => '$phrase'";
//    array_push($arrayForFile, $data);
//}
//
//$text = "<?php
//return array (\n    ".implode(",\n  ",$arrayForFile)."\n);";
//
//
//
//$fp = fopen($path."file_test.php", "w");
//fwrite($fp, $text);
//fclose($fp);
//die;
//

class PhrasesController extends Controller
{
    public function actionIndex()
    {

        set_time_limit(0);

//алгоритм создания массива с данными таблицы для выгрузки в файлы
        $phrases = Translations::model()->findAll();
        /** @var Translations $phrase*/
        $phraseAll = array();
        foreach ($phrases as $phrase){
            $phraseAll['ar'][$phrase->Category][$phrase->Key] = $phrase->LangAr;
            $phraseAll['az'][$phrase->Category][$phrase->Key] = $phrase->LangAz;
            $phraseAll['en'][$phrase->Category][$phrase->Key] = $phrase->LangEn;
            $phraseAll['es'][$phrase->Category][$phrase->Key] = $phrase->LangEs;
            $phraseAll['zh_cn'][$phrase->Category][$phrase->Key] = $phrase->LangCn;
            $phraseAll['my'][$phrase->Category][$phrase->Key] = $phrase->LangMy;
            $phraseAll['id'][$phrase->Category][$phrase->Key] = $phrase->LangId;
            $phraseAll['ru'][$phrase->Category][$phrase->Key] = $phrase->LangRu;
        }

        echo json_encode($phraseAll);
        exit();

////выгрузка массива в файлы
//        $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'messages-test'.DIRECTORY_SEPARATOR;
//
//        if(!is_dir($path)){
//            mkdir($path);
//        }
//
//        $arrayForFile = array();
//
//        foreach ($phraseAll as $lang => $categories) {
//            foreach($categories as $category => $keys){
//                foreach($keys as $key => $phrase){
//                    $data = '"'.$key.'" => "'.$phrase.'"';
//                    $arrayForFile[$lang][$category][] =  $data;
//                }
//            }
//        }
//        foreach ($arrayForFile as $lang => $categories){
//            foreach($categories as $category => $phrase){
//                if (!is_dir($path.$lang.DIRECTORY_SEPARATOR)){
//                    mkdir($path.$lang.DIRECTORY_SEPARATOR);
//                }
//                $file = $path.$lang.DIRECTORY_SEPARATOR.$category.".php";
//                $data = "<?php\nreturn array(\n    ".implode(",\n  ",$phrase)."\n);";
//                file_put_contents($file, $data);
//            }
//        }
//
//        echo "done!\n";
//        die;
    }
}