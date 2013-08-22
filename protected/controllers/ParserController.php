<?php
//
//set_time_limit(0);
//
//header("Content-Type: text/html; charset=utf-8");
//$connect = mysql_connect('localhost', 'root','');
//mysql_select_db('testdrive');
//mysql_query('set names utf8');
//
//if (mysql_query('TRUNCATE translations')){
//    $path = Yii::app()->basePath.'\messages\\';
//
//    $temp = scandir($path);
//
//    for($i=2;$i<count($temp);$i++)
//        $langs[]=$temp[$i];
//
////echo '$langs=("'.implode('","',$langs).'")'; die;
//
//
//
//    $categories = $temp = scandir($path.$langs[0].'\\');
//    unset($categories[0]);
//    unset($categories[1]);
//
//    $i=0;
//
//    foreach ($categories as $category){
//
//        $phrase = array ();
//        $cat_name = substr($category, 0,count($category)-5);
//
//        foreach ($langs as $lang){
//            $words_category = require($path.$lang.'\\'.$category);
//            foreach ($words_category as $key => $word) {
//                $key = htmlspecialchars($key);
//                $phrase[$key][$lang] = htmlspecialchars($word);
//            }
//        }
//        $phraseAll[$cat_name] = $phrase;
//    }
//
//    foreach ($phraseAll as $category => $keys){
//        foreach ($keys as $key => $languages){
//            foreach ($langs as $lang){
//                if (!isset($phraseAll[$category][$key][$lang])){
//                    $phraseAll[$category][$key][$lang] = '';
//                }
//            }
//            $sql = 'INSERT INTO `Translations` (`Category`, `Key`, `LangAr`, `LangEn`, `LangEs`, `LangId`, `LangMy`, `LangRu`, `LangCn`, `LangAz`) VALUES ("'.$category.'","'.$key.'","'.$phraseAll[$category][$key]["ar"].'","'.$phraseAll[$category][$key]["en"].'","'.$phraseAll[$category][$key]["es"].'","'.$phraseAll[$category][$key]["id"].'","'.$phraseAll[$category][$key]["my"].'","'.$phraseAll[$category][$key]["ru"].'","'.$phraseAll[$category][$key]["zh_cn"].'", "")';
//            $result = mysql_query($sql);
//            $i++;
//            if (!$result){
//                echo $sql;die;
//            }
//        }
//    }
//}
//// $phraseAll - этот массив можно формировать и передавать, убрав запись в базу
//
////echo 'done!'; die;
//
////после принятия массива проверяем на совпадения в БД
//
////foreach ($phraseAll as $category => $keys){
////    foreach ($keys as $key => $languages){
////        /** @var Translations $oldData */
////        $oldData = Translations::model()->findByAttributes(array('Category' => $category, 'Key' => $key));
////        if (!$oldData){
////            /** @var Translations $newData */
////            $newData = new Translations();
////            $newData->Category = $category;
////            $newData->Key = $key;
////            foreach ($languages as $language => $phrase){
////                switch($language){
////                    case 'ar':
////                        $newData->LangAr = htmlspecialchars($phrase);
////                        break;
////                    case 'es':
////                        $newData->LangEs = htmlspecialchars($phrase);
////                        break;
////                    case 'zh_cn':
////                        $newData->LangCn = htmlspecialchars($phrase);
////                        break;
////                    case 'my':
////                        $newData->LangMy = htmlspecialchars($phrase);
////                        break;
////                    case 'id':
////                        $newData->LangId = htmlspecialchars($phrase);
////                        break;
////                    case 'en':
////                        $newData->LangEn = htmlspecialchars($phrase);
////                        break;
////                    case 'ru':
////                        $newData->LangRu = htmlspecialchars($phrase);
////                        break;
////                }
////
////            }
////            $newData->save();
////        }
////    }
////}
//echo 'done!'; die;

