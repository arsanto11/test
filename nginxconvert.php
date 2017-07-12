server {
    listen 80 default_server;

    server_name localhost;

    charset utf-8;

    root /usr/share/nginx/www;
    index index.html index.htm index.php;
	
		location ~ \.php$ {
		try_files $uri =404;
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		fastcgi_cache  microcache;
		fastcgi_cache_key $scheme$host$request_uri$request_method;
		fastcgi_cache_valid 200 301 302 30s;
		fastcgi_cache_use_stale updating error timeout invalid_header http_500;
		fastcgi_pass_header Set-Cookie;
		fastcgi_pass_header Cookie;
		fastcgi_ignore_headers Cache-Control Expires Set-Cookie;
		fastcgi_pass unix:/var/run/php5-fpm.sock;
		fastcgi_index index.php;
		include fastcgi_params;
		add_header X-Cache $upstream_cache_status;
		
		


	
	}
	
	

    location ~* \.(?:ico|css|js|gif|jpe?g|png|svg|html|xml|otf|ttf|eot|woff)$ {
        expires 7d;
        access_log off;
        add_header Cache-Control public;
    }
	
	location ~* \.(?:css|js)$ {
	  expires 1y;
	  access_log off;
	  add_header Cache-Control public;
	}



    location / {
       try_files $uri $uri/ /index.php?$args;
    }

    location = /favicon.ico { log_not_found off; access_log off; }
    location = /robots.txt  { log_not_found off; access_log off; }
    location ~ /\. { deny all; log_not_found off; access_log off; }

    access_log /var/log/nginx/access.log;
    error_log  /var/log/nginx/error.log error;
    error_page 404 /index.php;
	
	
	rewrite ^/category$ /index.php?pagetype=1 last;
	rewrite "^/items/([0-9]+)_([a-zA-Z0-9]{5})/([a-zA-Z0-9-_]+).html$" /single.php?id=$1&token=$2&title=$3 last;
	rewrite ^/search/([a-zA-Z0-9-_]+).html$ /query.php?product=$1 last;
	rewrite ^/search$ /query.php last;



}
