Commerce Module error addint item to cart.

Location	https://schmidt-export.com/cart/add?_format=json
Referrer	https://schmidt-export.com/products
Symfony\Component\Routing\Exception\MethodNotAllowedException: in Drupal\Core\Routing\Router->matchRequest() (line 134 of /var/www/html/schmidt-new/web/core/lib/Drupal/Core/Routing/Router.php).

Apply patch:
```
diff --git a/core/lib/Drupal/Core/Routing/AccessAwareRouter.php b/core/lib/Drupal/Core/Routing/AccessAwareRouter.php
index b13006ca3f..8e245cb6f9 100644
--- a/core/lib/Drupal/Core/Routing/AccessAwareRouter.php
+++ b/core/lib/Drupal/Core/Routing/AccessAwareRouter.php
@@ -148,7 +148,7 @@ public function generate($name, $parameters = [], $referenceType = self::ABSOLUT
    *   Thrown when access checking failed.
    */
   public function match($pathinfo): array {
-    return $this->matchRequest(Request::create($pathinfo));
+    return $this->matchRequest(Request::createFromGlobals());
   }
 
 }
 ```
