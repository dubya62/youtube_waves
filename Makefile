
WEBROOT := /srv/http
INCLUDES := /srv/includes

all:
	cp -r root/* $(WEBROOT)
	cp scripts.php $(INCLUDES)
	-chown dubya:webadmin $(WEBROOT)/home_page/audios
	-chmod 775 $(WEBROOT)/home_page/audios
	-chown dubya:webadmin $(WEBROOT)/home_page/photos
	-chmod 775 $(WEBROOT)/home_page/photos

clean:
	rm -rf $(WEBROOT)/*
	rm -rf $(INCLUDES)/*
