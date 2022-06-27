<?php
namespace Drupal\comment_locale_filter\Storage;

use Drupal\comment\CommentInterface;
use Drupal\comment\CommentManagerInterface;
use Drupal\comment\CommentStorage as ParentCommentStorage;
use Drupal\Core\Entity\EntityInterface;

class CommentStorage extends ParentCommentStorage {
 public function loadThread(EntityInterface $entity, $field_name, $mode, $comments_per_page = 0, $pager_id = 0) {
   $langCode = $this->languageManager->getCurrentLanguage()->getId();
   $query = $this->database->select('comment_field_data', 'c');
   $query->addField('c', 'cid');
   $query
     ->condition('c.entity_id', $entity->id())
     ->condition('c.entity_type', $entity->getEntityTypeId())
     ->condition('c.field_name', $field_name)
     ->condition('c.langcode', $langCode) // this is the language condition
     ->condition('c.default_langcode', 1)
     ->addTag('entity_access')
     ->addTag('comment_filter')
     ->addMetaData('base_table', 'comment')
     ->addMetaData('entity', $entity)
     ->addMetaData('field_name', $field_name);

   if ($comments_per_page) {
     $query = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender');
      $query->limit($comments_per_page);
     if ($pager_id) {
       $query->element($pager_id);
     }

     $count_query = $this->database->select('comment_field_data', 'c');
     $count_query->addExpression('COUNT(*)');
     $count_query
       ->condition('c.entity_id', $entity->id())
       ->condition('c.entity_type', $entity->getEntityTypeId())
       ->condition('c.field_name', $field_name)
       ->condition('c.langcode', $langCode)  // this is the language condition
       ->condition('c.default_langcode', 1)
       ->addTag('entity_access')
       ->addTag('comment_filter')
       ->addMetaData('base_table', 'comment')
       ->addMetaData('entity', $entity)
       ->addMetaData('field_name', $field_name);
       $query->setCountQuery($count_query);
   }

   $allStatusGroup = $query->orConditionGroup()
     ->condition('c.status', CommentInterface::NOT_PUBLISHED)
     ->condition('c.status', CommentInterface::PUBLISHED);

   if ($this->currentUser->hasPermission('administer comments')) {
     $query->condition($allStatusGroup);
     if ($comments_per_page) {
       $count_query->condition($allStatusGroup);
     }
   } else {
     $query->condition('c.status', CommentInterface::PUBLISHED);
     if ($comments_per_page) {
       $count_query->condition('c.status', CommentInterface::PUBLISHED);
     }
   }
   if ($mode == CommentManagerInterface::COMMENT_MODE_FLAT) {
     $query->orderBy('c.cid', 'ASC');
   }
   else {
     $query->addExpression('SUBSTRING(c.thread, 1, (LENGTH(c.thread) - 1))', 'torder');
     $query->orderBy('torder', 'ASC');
   }
   $cids = $query->execute()->fetchCol();

   $comments = [];
   if ($cids) {
     $comments = $this->loadMultiple($cids);
    }
    return $comments;
  }
}
