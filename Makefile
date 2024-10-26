
WEBROOT := /srv/http
INCLUDES := /srv/includes

all:
	cp -r root/* $(WEBROOT)
	cp scripts.php $(INCLUDES)
	-mkdir $(WEBROOT)/home_page/audios
	-mkdir $(WEBROOT)/home_page/images
	-chown dubya:webadmin $(WEBROOT)/home_page/audios
	-chmod 775 $(WEBROOT)/home_page/audios
	-chown dubya:webadmin $(WEBROOT)/home_page/images
	-chmod 775 $(WEBROOT)/home_page/images

clean:
	rm -rf $(WEBROOT)/*
	rm -rf $(INCLUDES)/*
