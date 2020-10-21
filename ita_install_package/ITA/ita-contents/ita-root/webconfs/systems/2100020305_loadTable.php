<?php
//   Copyright 2019 NEC Corporation
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.
//
//////////////////////////////////////////////////////////////////////
//
//  【処理概要】
//    ・Ansible（Legacy Role）ロール変数名管理
//
//////////////////////////////////////////////////////////////////////

$tmpFx = function (&$aryVariant=array(),&$arySetting=array()){
    global $g;

    $arrayWebSetting = array();
    $arrayWebSetting['page_info'] = $g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601010");
/*
Ansible（Legacy Role）ロール変数名管理
*/
    $tmpAry = array(
        'TT_SYS_01_JNL_SEQ_ID'=>'JOURNAL_SEQ_NO',
        'TT_SYS_02_JNL_TIME_ID'=>'JOURNAL_REG_DATETIME',
        'TT_SYS_03_JNL_CLASS_ID'=>'JOURNAL_ACTION_CLASS',
        'TT_SYS_04_NOTE_ID'=>'NOTE',
        'TT_SYS_04_DISUSE_FLAG_ID'=>'DISUSE_FLAG',
        'TT_SYS_05_LUP_TIME_ID'=>'LAST_UPDATE_TIMESTAMP',
        'TT_SYS_06_LUP_USER_ID'=>'LAST_UPDATE_USER',
        'TT_SYS_NDB_ROW_EDIT_BY_FILE_ID'=>'ROW_EDIT_BY_FILE',
        'TT_SYS_NDB_UPDATE_ID'=>'WEB_BUTTON_UPDATE',
        'TT_SYS_NDB_LUP_TIME_ID'=>'UPD_UPDATE_TIMESTAMP'
    );

    $table = new TableControlAgent('B_ANSIBLE_LRL_ROLE_VARS','VARS_NAME_ID', $g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601020"), 'B_ANSIBLE_LRL_ROLE_VARS_JNL', $tmpAry);
    $tmpAryColumn = $table->getColumns();
    $tmpAryColumn['VARS_NAME_ID']->setSequenceID('B_ANSIBLE_LRL_ROLE_VARS_RIC');
    $tmpAryColumn['JOURNAL_SEQ_NO']->setSequenceID('B_ANSIBLE_LRL_ROLE_VARS_JSQ');
    unset($tmpAryColumn);

    // QMファイル名プレフィックス
    $table->setDBMainTableLabel($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601030"));
    // エクセルのシート名
    $table->getFormatter('excel')->setGeneValue('sheetNameForEditByFile',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601040"));

    $table->setAccessAuth(true);    // データごとのRBAC設定


    $c = new IDColumn('ROLE_PACKAGE_ID',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601050"),'B_ANSIBLE_LRL_ROLE_PACKAGE','ROLE_PACKAGE_ID','ROLE_PACKAGE_NAME','');
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601060"));//エクセル・ヘッダでの説明
    $c->setJournalTableOfMaster('B_ANSIBLE_LRL_ROLE_PACKAGE_JNL');
    $c->setJournalSeqIDOfMaster('JOURNAL_SEQ_NO');
    $c->setJournalLUTSIDOfMaster('LAST_UPDATE_TIMESTAMP');
    $c->setJournalKeyIDOfMaster('ROLE_PACKAGE_ID');
    $c->setJournalDispIDOfMaster('ROLE_PACKAGE_NAME');
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    $c = new IDColumn('ROLE_ID',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601070"),'B_ANSIBLE_LRL_ROLE','ROLE_ID','ROLE_NAME','');
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601080"));//エクセル・ヘッダでの説明
    $c->setJournalTableOfMaster('B_ANSIBLE_LRL_ROLE_JNL');
    $c->setJournalSeqIDOfMaster('JOURNAL_SEQ_NO');
    $c->setJournalLUTSIDOfMaster('LAST_UPDATE_TIMESTAMP');
    $c->setJournalKeyIDOfMaster('ROLE_ID');
    $c->setJournalDispIDOfMaster('ROLE_NAME');
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    $objVldt = new SingleTextValidator(1,256,false);
    $c = new TextColumn('VARS_NAME',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1601090"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1602010"));//エクセル・ヘッダでの説明
    $c->setValidator($objVldt);
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    $c = new IDColumn('VARS_ATTRIBUTE_01',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305015"),'B_ANS_VARS_TYPE','VARS_TYPE_ID','VARS_TYPE_NAME','',array('OrderByThirdColumn'=>'VARS_TYPE_ID'));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305016"));//エクセル・ヘッダでの説明
    $c->setJournalTableOfMaster('B_ANS_VARS_TYPE_JNL');
    $c->setJournalSeqIDOfMaster('JOURNAL_SEQ_NO');
    $c->setJournalLUTSIDOfMaster('LAST_UPDATE_TIMESTAMP');
    $c->setJournalKeyIDOfMaster('VARS_TYPE_ID');
    $c->setJournalDispIDOfMaster('VARS_TYPE_NAME');
    $table->addColumn($c);

//----head of setting [multi-set-unique]
    $table->addUniqueColumnSet(array('ROLE_PACKAGE_ID','ROLE_ID','VARS_NAME'));
//tail of setting [multi-set-unique]----

    $table->fixColumn();

    $table->setGeneObject('webSetting', $arrayWebSetting);
    return $table;
};
loadTableFunctionAdd($tmpFx,__FILE__);
unset($tmpFx);
?>
