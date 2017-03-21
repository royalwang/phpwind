<?php

defined('WEKIT_VERSION') || exit('Forbidden');

/**
 * 帖子删除扩展服务接口--删除帖子话题.
 *
 * @author jinlong.panjl <jinlong.panjl@aliyun-inc.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.phpwind.com
 *
 * @version $Id$
 */
class PwDeleteTopicDoTagDelete extends iPwGleanDoHookProcess
{
    public function run($ids)
    {
        $ds = Wekit::load('tag.PwTag');
        $tags = $ds->fetchByTypeIdAndParamIds(PwTag::TYPE_THREAD_TOPIC, $ids);
        $tagIds = array_keys($tags);
        if (! $tagIds) {
            return false;
        }
        $ds->batchDeleteRelation(PwTag::TYPE_THREAD_TOPIC, $ids);

        $dm = new PwTagDm();
        $dm->addContentCount(-1);
        $ds->updateTags($tagIds, $dm);
    }
}
