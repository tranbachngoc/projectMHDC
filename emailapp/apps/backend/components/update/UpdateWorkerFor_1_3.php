<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * UpdateWorkerFor_1_3
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2016 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3
 */
 
class UpdateWorkerFor_1_3 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.3');

        // select available campaigns to create the campaign option connection
        $command = $this->db->createCommand('SELECT campaign_id FROM {{campaign}} WHERE 1');
        $results = $command->queryAll();
        
        foreach ($results as $result) {
            $command = $this->db->createCommand('INSERT INTO {{campaign_option}} SET campaign_id = :cid, url_tracking = "yes"');
            $command->execute(array(
                ':cid'  => (int)$result['campaign_id'],
            ));            
        }

    }
} 