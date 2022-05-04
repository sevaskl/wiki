После обновления модуля требуется добавить след. строки:

1. \var\www\html\schmidt-new\web\modules\contrib\tb_megamenu\tb_megamenu.module

```
    18 строка
//After updating you have to add these
use Drupal\Core\Menu\MenuLinkInterface;
use Drupal\menu_link_content\Plugin\Menu\MenuLinkContent;

    684 строка
  }
  // Add this 
   $vars['close']=[];
   $language = Drupal::languageManager()->getCurrentLanguage()->getId();
  $lang=MY_MODULE_menu_item_cleanup($item->link, $language);
  if(!$lang){
	  $vars['close'] = '1';
  }
  //
}

    758 строка
// These 2 modules
function MY_MODULE_menu_item_cleanup(&$item, $language) {


   $menuLinkEntity = MY_MODULE_load_link_entity_by_link($item);

    // Ignore if we don´t have a menu object.
    if ($menuLinkEntity != NULL) {
      $languages = $menuLinkEntity->getTranslationLanguages();
     //  return $languages;
      // Remove links with different language than context.
      if (array_key_exists($language, $languages)) {
        return true;
      }
     
    }
   
  return false;
}
function MY_MODULE_load_link_entity_by_link(MenuLinkInterface $menuLinkContentPlugin) {
  $entity = NULL;

  if ($menuLinkContentPlugin instanceof MenuLinkContent) {
    list($entity_type, $uuid) = explode(':', $menuLinkContentPlugin->getPluginId(), 2);
    $entity = \Drupal::service('entity.repository')->loadEntityByUuid($entity_type, $uuid);
  }
  
  return $entity;
}
```
