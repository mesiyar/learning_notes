# thinkphp5.1 路由重写规则


phpStudy 环境

```
<IfModule mod_rewrite.c>
 Options +FollowSymlinks -Multiviews

RewriteEngine on RewriteCond %{REQUEST_FILENAME} !-d

RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]

</IfModule>
```

nginx 环境
```
location / { 
    if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
        break;
    }
}
```

apache
```
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```
