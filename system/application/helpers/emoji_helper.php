<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
     ***************************************************************************
     * Created: 2018/08/29
     * Emoji Smile
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return true or false
     *  
     ***************************************************************************
    */


    if(!function_exists('getEmojiSmile')) {
		function getEmojiSmile() {

            $aSmile = array(
                'smile_1'   => array(
                    'text'  => '\ud83d\ude00',
                    'image' => ''
                ),
                'smile_2'   => array(
                    'text'  => '\ud83d\ude03',
                    'image' => ''
                ),
                'smile_3'   => array(
                    'text'  => '\ud83d\ude04',
                    'image' => ''
                ),
                'smile_4'   => array(
                    'text'  => '\ud83d\ude01',
                    'image' => ''
                ),
                'smile_5'   => array(
                    'text'  => '\ud83d\ude06',
                    'image' => ''
                ),
                'smile_6'   => array(
                    'text'  => '\ud83d\ude05',
                    'image' => ''
                ),
                'smile_7'   => array(
                    'text'  => '\ud83d\ude02',
                    'image' => ''
                ),
                'smile_8'   => array(
                    'text'  => '\ud83e\udd23',
                    'image' => ''
                ),
                'smile_9'   => array(
                    'text'  => '\u263a',
                    'image' => ''
                ),
                'smile_10'  => array(
                    'text'  => '\ud83d\ude0a',
                    'image' => ''
                ),
                'smile_11'  => array(
                    'text'  => '\ud83d\ude07',
                    'image' => ''
                ),
                'smile_12'  => array(
                    'text'  => '\ud83d\ude42',
                    'image' => ''
                ),
                'smile_13'  => array(
                    'text'  => '\ud83d\ude43',
                    'image' => '' 
                ),
                'smile_14'  => array(
                    'text'  => '\ud83d\ude09',
                    'image' => ''
                ),
                'smile_15'  => array(
                    'text'  => '\ud83d\ude0c',
                    'image' => ''
                ),
                'smile_16'  => array(
                    'text'  => '\ud83d\ude0d',
                    'image' => ''
                ),
                'smile_17'  => array(
                    'text'  => '\ud83d\ude18',
                    'image' => ''
                ),
                'smile_18'  => array(
                    'text'  => '\ud83d\ude17',
                    'image' => ''
                ),
                'smile_19'  => array(
                    'text'  => '\ud83d\ude19',
                    'image' => ''
                ),
                'smile_20'  => array(
                    'text'  => '\ud83d\ude1a',
                    'image' => ''
                ),
                'smile_21'  => array(
                    'text'  => '\ud83d\ude0b',
                    'image' => ''
                ),
                'smile_22'  => array(
                    'text'  => '\ud83d\ude1c',
                    'image' => ''
                ),
                'smile_23'  => array(
                    'text'  => '\ud83d\ude1d',
                    'image' => ''
                ),
                'smile_24'  => array(
                    'text'  => '\ud83d\ude1b',
                    'image' => ''
                ),
                'smile_25'  => array(
                    'text'  => '\ud83e\udd11',
                    'image' => ''
                ),
                'smile_26'  => array(
                    'text'  => '\ud83e\udd17',
                    'image' => ''
                ),
                'smile_27'  => array(
                    'text'  => '\ud83e\udd13',
                    'image' => ''
                ),
                'smile_28'  => array(
                    'text'  => '\ud83d\ude0e',
                    'image' => ''
                ),
                'smile_29'  => array(
                    'text'  => '\ud83e\udd21',
                    'image' => ''
                ),
                'smile_30'  => array(
                    'text'  => '\ud83e\udd20',
                    'image' => ''
                ),
                'smile_31'  => array(
                    'text'  => '\ud83d\ude0f',
                    'image' => ''
                ),
                'smile_32'  => array(
                    'text'  => '\ud83d\ude12',
                    'image' => ''
                ),
                'smile_33'  => array(
                    'text'  => '\ud83d\ude1e',
                    'image' => ''
                ),
                'smile_34'  => array(
                    'text'  => '\ud83d\ude14',
                    'image' => ''
                ),
                'smile_35'  => array(
                    'text'  => '\ud83d\ude1f',
                    'image' => ''
                ),
                'smile_36'  => array(
                    'text'  => '\ud83d\ude15',
                    'image' => ''
                ),
                'smile_37'  => array(
                    'text'  => '\ud83d\ude41',
                    'image' => ''
                ),
                'smile_38'  => array(
                    'text'  => '\u2639',
                    'image' => ''
                ),
                'smile_39'  => array(
                    'text'  => '\ud83d\ude23',
                    'image' => ''
                ),
                'smile_40'  => array(
                    'text'  => '\ud83d\ude16',
                    'image' => ''
                ),
                'smile_41'  => array(
                    'text'  => '\ud83d\ude2b',
                    'image' => ''
                ),
                'smile_42'  => array(
                    'text'  => '\ud83d\ude29',
                    'image' => ''
                ),
                'smile_43'  => array(
                    'text'  => '\ud83d\ude24',
                    'image' => ''
                ),
                'smile_44'  => array(
                    'text'  => '\ud83d\ude20',
                    'image' => ''
                ),
                'smile_45'  => array(
                    'text'  => '\ud83d\ude21',
                    'image' => ''
                ),
                'smile_46'  => array(
                    'text'  => '\ud83d\ude36',
                    'image' => ''
                ),
                'smile_47'  => array(
                    'text'  => '\ud83d\ude10',
                    'image' => ''
                ),
                'smile_48'  => array(
                    'text'  => '\ud83d\ude11',
                    'image' => ''
                ),
                'smile_49'  => array(
                    'text'  => '\ud83d\ude2f',
                    'image' => ''
                ),
                'smile_50'  => array(
                    'text'  => '\ud83d\ude26',
                    'image' => ''
                ),
                'smile_51'  => array(
                    'text'  => '\ud83d\ude27',
                    'image' => ''
                ),
                'smile_52'  => array(
                    'text'  => '\ud83d\ude2e',
                    'image' => ''
                ),
                'smile_53'  => array(
                    'text'  => '\ud83d\ude32',
                    'image' => ''
                ),
                'smile_54'  => array(
                    'text'  => '\ud83d\ude35',
                    'image'
                )
            );

            $aAnimal = array(
                'animal_1'   => array(
                    'text'  => '\ud83d\udc36',
                    'image' => ''
                ),
                'animal_2'   => array(
                    'text'  => '\ud83d\udc31',
                    'image' => ''
                ),
                'animal_3'   => array(
                    'text'  => '\ud83d\udc2d',
                    'image' => ''
                ),
                'animal_4'   => array(
                    'text'  => '\ud83d\udc39',
                    'image' => ''
                ),
                'animal_5'   => array(
                    'text'  => '\ud83d\udc30',
                    'image' => ''
                ),
                'animal_6'   => array(
                    'text'  => '\ud83e\udd8a',
                    'image' => ''
                ),
                'animal_7'   => array(
                    'text'  => '\ud83d\udc3b',
                    'image' => ''
                ),
                'animal_8'   => array(
                    'text'  => '\ud83d\udc3c',
                    'image' => ''
                ),
                'animal_9'   => array(
                    'text'  => '\ud83d\udc28',
                    'image' => ''
                ),
                'animal_10'   => array(
                    'text'  => '\ud83d\udc2f',
                    'image' => ''
                ),
                'animal_11'   => array(
                    'text'  => '\ud83e\udd81',
                    'image' => ''
                ),
                'animal_12'   => array(
                    'text'  => '\ud83d\udc2e',
                    'image' => ''
                ),
                'animal_13'   => array(
                    'text'  => '\ud83d\udc37',
                    'image' => ''
                ),
                'animal_14'   => array(
                    'text'  => '\ud83d\udc3d',
                    'image' => ''
                ),
                'animal_15'   => array(
                    'text'  => '\ud83d\udc38',
                    'image' => ''
                ),
                'animal_16'   => array(
                    'text'  => '\ud83d\udc35',
                    'image' => ''
                ),
                'animal_17'   => array(
                    'text'  => '\ud83d\ude48',
                    'image' => ''
                ),
                'animal_18'   => array(
                    'text'  => '\ud83d\ude49',
                    'image' => ''
                ),
                'animal_19'   => array(
                    'text'  => '\ud83d\ude4a',
                    'image' => ''
                ),
                'animal_20'   => array(
                    'text'  => '\ud83d\udc12',
                    'image' => ''
                ),
                'animal_21'   => array(
                    'text'  => '\ud83d\udc14',
                    'image' => ''
                ),
                'animal_22'   => array(
                    'text'  => '\ud83d\udc27',
                    'image' => ''
                ),
                'animal_23'   => array(
                    'text'  => '\ud83d\udc26',
                    'image' => ''
                ),
                'animal_24'   => array(
                    'text'  => '\ud83d\udc24',
                    'image' => ''
                ),
                'animal_25'   => array(
                    'text'  => '\ud83d\udc23',
                    'image' => ''
                ),
                'animal_26'   => array(
                    'text'  => '\ud83d\udc25',
                    'image' => ''
                ),
                'animal_27'   => array(
                    'text'  => '\ud83e\udd86',
                    'image' => ''
                ),
                'animal_28'   => array(
                    'text'  => '\ud83e\udd85',
                    'image' => ''
                ),
                'animal_29'   => array(
                    'text'  => '\ud83e\udd89',
                    'image' => ''
                ),
                'animal_30'   => array(
                    'text'  => '\ud83e\udd87',
                    'image' => ''
                ),
                'animal_31'   => array(
                    'text'  => '\ud83d\udc3a',
                    'image' => ''
                ),
                'animal_32'   => array(
                    'text'  => '\ud83d\udc17',
                    'image' => ''
                ),
                'animal_33'   => array(
                    'text'  => '\ud83d\udc34',
                    'image' => ''
                ),
                'animal_34'   => array(
                    'text'  => '\ud83e\udd84',
                    'image' => ''
                ),
                'animal_35'   => array(
                    'text'  => '\ud83d\udc1d',
                    'image' => ''
                ),
                'animal_36'   => array(
                    'text'  => '\ud83d\udc1b',
                    'image' => ''
                ),
                'animal_37'   => array(
                    'text'  => '\ud83e\udd8b',
                    'image' => ''
                ),
                'animal_38'   => array(
                    'text'  => '\ud83d\udc0c',
                    'image' => ''
                ),
                'animal_39'   => array(
                    'text'  => '\ud83d\udc1a',
                    'image' => ''
                ),
                'animal_40'   => array(
                    'text'  => '\ud83d\udc1e',
                    'image' => ''
                ),
                'animal_41'   => array(
                    'text'  => '\ud83d\udc1c',
                    'image' => ''
                ),
                'animal_42'   => array(
                    'text'  => '\ud83d\udd77',
                    'image' => ''
                ),
                'animal_43'   => array(
                    'text'  => '\ud83d\udd78',
                    'image' => ''
                ),
                'animal_44'   => array(
                    'text'  => '\ud83d\udc22',
                    'image' => ''
                ),
                'animal_45'   => array(
                    'text'  => '\ud83d\udc0d',
                    'image' => ''
                ),
                'animal_46'   => array(
                    'text'  => '\ud83e\udd8e',
                    'image' => ''
                ),
                'animal_47'   => array(
                    'text'  => '\ud83e\udd82',
                    'image' => ''
                ),
                'animal_48'   => array(
                    'text'  => '\ud83e\udd80',
                    'image' => ''
                ),
                'animal_49'   => array(
                    'text'  => '\ud83e\udd91',
                    'image' => ''
                ),
                'animal_50'   => array(
                    'text'  => '\ud83d\udc19',
                    'image' => ''
                ),
                'animal_51'   => array(
                    'text'  => '\ud83e\udd90',
                    'image' => ''
                ),
                'animal_52'   => array(
                    'text'  => '\ud83d\udc20',
                    'image' => ''
                ),
                'animal_53'   => array(
                    'text'  => '\ud83d\udc1f',
                    'image' => ''
                ),
                'animal_54'   => array(
                    'text'  => '\ud83d\udc21',
                    'image' => ''
                ),
            );

            $aFood = array(
                'food_1'   => array(
                    'text'  => '\ud83c\udf4f',
                    'image' => ''
                ),
                'food_2'   => array(
                    'text'  => '\ud83c\udf4e',
                    'image' => ''
                ),
                'food_3'   => array(
                    'text'  => '\ud83c\udf50',
                    'image' => ''
                ),
                'food_4'   => array(
                    'text'  => '\ud83c\udf4a',
                    'image' => ''
                ),
                'food_5'   => array(
                    'text'  => '\ud83c\udf4b',
                    'image' => ''
                ),
                'food_6'   => array(
                    'text'  => '\ud83c\udf4c',
                    'image' => ''
                ),
                'food_7'   => array(
                    'text'  => '\ud83c\udf49',
                    'image' => ''
                ),
                'food_8'   => array(
                    'text'  => '\ud83c\udf47',
                    'image' => ''
                ),
                'food_9'   => array(
                    'text'  => '\ud83c\udf53',
                    'image' => ''
                ),
                'food_10'   => array(
                    'text'  => '\ud83c\udf48',
                    'image' => ''
                ),
                'food_11'   => array(
                    'text'  => '\ud83c\udf52',
                    'image' => ''
                ),
                'food_12'   => array(
                    'text'  => '\ud83c\udf51',
                    'image' => ''
                ),
                'food_13'   => array(
                    'text'  => '\ud83c\udf4d',
                    'image' => ''
                ),
                'food_14'   => array(
                    'text'  => '\ud83e\udd5d',
                    'image' => ''
                ),
                'food_15'   => array(
                    'text'  => '\ud83e\udd51',
                    'image' => ''
                ),
                'food_16'   => array(
                    'text'  => '\ud83c\udf45',
                    'image' => ''
                ),
                'food_17'   => array(
                    'text'  => '\ud83c\udf46',
                    'image' => ''
                ),
                'food_18'   => array(
                    'text'  => '\ud83e\udd52',
                    'image' => ''
                ),
                'food_19'   => array(
                    'text'  => '\ud83e\udd55',
                    'image' => ''
                ),
                'food_20'   => array(
                    'text'  => '\ud83c\udf3d',
                    'image' => ''
                ),
                'food_21'   => array(
                    'text'  => '\ud83c\udf36',
                    'image' => ''
                ),
                'food_22'   => array(
                    'text'  => '\ud83e\udd54',
                    'image' => ''
                ),
                'food_23'   => array(
                    'text'  => '\ud83c\udf60',
                    'image' => ''
                ),
                'food_24'   => array(
                    'text'  => '\ud83c\udf30',
                    'image' => ''
                ),
                'food_25'   => array(
                    'text'  => '\ud83e\udd5c',
                    'image' => ''
                ),
                'food_26'   => array(
                    'text'  => '\ud83c\udf6f',
                    'image' => ''
                ),
                'food_27'   => array(
                    'text'  => '\ud83e\udd50',
                    'image' => ''
                ),
                'food_28'   => array(
                    'text'  => '\ud83c\udf5e',
                    'image' => ''
                ),
                'food_29'   => array(
                    'text'  => '\ud83e\udd56',
                    'image' => ''
                ),
                'food_30'   => array(
                    'text'  => '\ud83e\uddc0',
                    'image' => ''
                ),
                'food_31'   => array(
                    'text'  => '\ud83e\udd5a',
                    'image' => ''
                ),
                'food_32'   => array(
                    'text'  => '\ud83c\udf73',
                    'image' => ''
                ),
                'food_33'   => array(
                    'text'  => '\ud83e\udd53',
                    'image' => ''
                ),
                'food_34'   => array(
                    'text'  => '\ud83e\udd5e',
                    'image' => ''
                ),
                'food_35'   => array(
                    'text'  => '\ud83c\udf64',
                    'image' => ''
                ),
                'food_36'   => array(
                    'text'  => '\ud83c\udf57',
                    'image' => ''
                ),
                'food_37'   => array(
                    'text'  => '\ud83c\udf56',
                    'image' => ''
                ),
                'food_38'   => array(
                    'text'  => '\ud83c\udf55',
                    'image' => ''
                ),
                'food_39'   => array(
                    'text'  => '\ud83c\udf2d',
                    'image' => ''
                ),
                'food_40'   => array(
                    'text'  => '\ud83c\udf54',
                    'image' => ''
                ),
                'food_41'   => array(
                    'text'  => '\ud83c\udf5f',
                    'image' => ''
                ),
                'food_42'   => array(
                    'text'  => '\ud83e\udd59',
                    'image' => ''
                ),
                'food_43'   => array(
                    'text'  => '\ud83c\udf2e',
                    'image' => ''
                ),
                'food_44'   => array(
                    'text'  => '\ud83c\udf2f',
                    'image' => ''
                ),
                'food_45'   => array(
                    'text'  => '\ud83e\udd57',
                    'image' => ''
                ),
                'food_46'   => array(
                    'text'  => '\ud83e\udd58',
                    'image' => ''
                ),
                'food_47'   => array(
                    'text'  => '\ud83c\udf5d',
                    'image' => ''
                ),
                'food_48'   => array(
                    'text'  => '\ud83c\udf5c',
                    'image' => ''
                ),
                'food_49'   => array(
                    'text'  => '\ud83c\udf72',
                    'image' => ''
                ),
                'food_50'   => array(
                    'text'  => '\ud83c\udf65',
                    'image' => ''
                ),
                'food_51'   => array(
                    'text'  => '\ud83c\udf63',
                    'image' => ''
                ),
                'food_52'   => array(
                    'text'  => '\ud83c\udf71',
                    'image' => ''
                ),
                'food_53'   => array(
                    'text'  => '\ud83c\udf5b',
                    'image' => ''
                ),
                'food_54'   => array(
                    'text'  => '\ud83c\udf59',
                    'image' => ''
                )
            );
            
            $aSport = array(
                'sport_1'   => array(
                    'text'  => '\u26bd',
                    'image' => ''
                ),
                'sport_2'   => array(
                    'text'  => '\ud83c\udfc0',
                    'image' => ''
                ),
                'sport_3'   => array(
                    'text'  => '\ud83c\udfc8',
                    'image' => ''
                ),
                'sport_4'   => array(
                    'text'  => '\u26be',
                    'image' => ''
                ),
                'sport_5'   => array(
                    'text'  => '\ud83c\udfbe',
                    'image' => ''
                ),
                'sport_6'   => array(
                    'text'  => '\ud83c\udfd0',
                    'image' => ''
                ),
                'sport_7'   => array(
                    'text'  => '\ud83c\udfc9',
                    'image' => ''
                ),
                'sport_8'   => array(
                    'text'  => '\ud83c\udfb1',
                    'image' => ''
                ),
                'sport_9'   => array(
                    'text'  => '\ud83c\udfd3',
                    'image' => ''
                ),
                'sport_10'   => array(
                    'text'  => '\ud83c\udff8',
                    'image' => ''
                ),
                'sport_11'   => array(
                    'text'  => '\ud83e\udd45',
                    'image' => ''
                ),
                'sport_12'   => array(
                    'text'  => '\ud83c\udfd2',
                    'image' => ''
                ),
                'sport_13'   => array(
                    'text'  => '\ud83c\udfd1',
                    'image' => ''
                ),
                'sport_14'   => array(
                    'text'  => '\ud83c\udfcf',
                    'image' => ''
                ),
                'sport_15'   => array(
                    'text'  => '\u26f3',
                    'image' => ''
                ),
                'sport_16'   => array(
                    'text'  => '\ud83c\udff9',
                    'image' => ''
                ),
                'sport_17'   => array(
                    'text'  => '\ud83c\udfa3',
                    'image' => ''
                ),
                'sport_18'   => array(
                    'text'  => '\ud83e\udd4a',
                    'image' => ''
                ),
                'sport_19'   => array(
                    'text'  => '\ud83e\udd4b',
                    'image' => ''
                ),
                'sport_20'   => array(
                    'text'  => '\u26f8',
                    'image' => ''
                ),
                'sport_21'   => array(
                    'text'  => '\ud83c\udfbf',
                    'image' => ''
                ),
                'sport_22'   => array(
                    'text'  => '\u26f7',
                    'image' => ''
                ),
                'sport_23'   => array(
                    'text'  => '\ud83c\udfc2',
                    'image' => ''
                ),
                'sport_24'   => array(
                    'text'  => '\ud83c\udfcb\ufe0f\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_25'   => array(
                    'text'  => '\ud83c\udfcb',
                    'image' => ''
                ),
                'sport_26'   => array(
                    'text'  => '\ud83e\udd3a',
                    'image' => ''
                ),
                'sport_27'   => array(
                    'text'  => '\ud83e\udd3c\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_28'   => array(
                    'text'  => '\ud83e\udd3c\u200d\u2642\ufe0f',
                    'image' => ''
                ),
                'sport_29'   => array(
                    'text'  => '\ud83e\udd38\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_30'   => array(
                    'text'  => '\ud83e\udd38\u200d\u2642\ufe0f',
                    'image' => ''
                ),
                'sport_31'   => array(
                    'text'  => '\u26f9\ufe0f\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_32'   => array(
                    'text'  => '\u26f9',
                    'image' => ''
                ),
                'sport_33'   => array(
                    'text'  => '\ud83e\udd3e\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_34'   => array(
                    'text'  => '\ud83e\udd3e\u200d\u2642\ufe0f',
                    'image' => ''
                ),
                'sport_35'   => array(
                    'text'  => '\ud83c\udfcc\ufe0f\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_36'   => array(
                    'text'  => '\ud83c\udfcc',
                    'image' => ''
                ),
                'sport_37'   => array(
                    'text'  => '\ud83c\udfc4\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_38'   => array(
                    'text'  => '\ud83c\udfc4',
                    'image' => ''
                ),
                'sport_39'   => array(
                    'text'  => '\ud83c\udfca\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_40'   => array(
                    'text'  => '\ud83c\udfca',
                    'image' => ''
                ),
                'sport_41'   => array(
                    'text'  => '\ud83e\udd3d\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_42'   => array(
                    'text'  => '\ud83e\udd3d\u200d\u2642\ufe0f',
                    'image' => ''
                ),
                'sport_43'   => array(
                    'text'  => '\ud83d\udea3\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_44'   => array(
                    'text'  => '\ud83d\udea3',
                    'image' => ''
                ),
                'sport_45'   => array(
                    'text'  => '\ud83c\udfc7',
                    'image' => ''
                ),
                'sport_46'   => array(
                    'text'  => '\ud83d\udeb4\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_47'   => array(
                    'text'  => '\ud83d\udeb4',
                    'image' => ''
                ),
                'sport_48'   => array(
                    'text'  => '\ud83d\udeb5\u200d\u2640\ufe0f',
                    'image' => ''
                ),
                'sport_49'   => array(
                    'text'  => '\ud83d\udeb5',
                    'image' => ''
                ),
                'sport_50'   => array(
                    'text'  => '\ud83c\udfbd',
                    'image' => ''
                ),
                'sport_51'   => array(
                    'text'  => '\ud83c\udfc5',
                    'image' => ''
                ),
                'sport_52'   => array(
                    'text'  => '\ud83c\udf96',
                    'image' => ''
                ),
                'sport_53'   => array(
                    'text'  => '\ud83e\udd47',
                    'image' => ''
                ),
                'sport_54'   => array(
                    'text'  => '\ud83e\udd48',
                    'image' => ''
                ),
            );

			$aListEmoji = array(
                'aSmile'    => array(
                    'title' => 'Mặt cười và mọi người',
                    'icon'  => 'templates/home/styles/images/svg/smile.svg',
                    'data'  => $aSmile
                ),
                'aAnimal'   => array(
                    'title' => 'Động vật và thiên nhiên',
                    'icon'  => 'templates/home/styles/images/svg/bear.svg',
                    'data'  => $aAnimal
                ),
                'aFood'     => array(
                    'title' => 'Thực phẩm và đồ uống',
                    'icon'  => 'templates/home/styles/images/svg/coffee-cup.svg',
                    'data'  => $aFood
                ),
                'aSport'    => array(
                    'title' => 'Hoạt động',
                    'icon'  => 'templates/home/styles/images/svg/football-ball.svg',
                    'data'  => $aSport
                )
            );

            return $aListEmoji;
		}
	}

    if(!function_exists('convertEmoji')) {
        function convertEmoji($string = '') {
            $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $string);
            $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
            $result = mb_convert_encoding($result, 'utf-8', 'utf-16');

            return $result;
        }
    }
?>