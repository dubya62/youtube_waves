
WEBROOT := /srv/http
INCLUDES := /srv/includes

all:
	cp -r root/* $(WEBROOT)
	cp scripts.php $(INCLUDES)
	-mkdir $(WEBROOT)/home_page/audios
	-mkdir $(WEBROOT)/home_page/images
	-mkdir $(WEBROOT)/home_page/comments
	-mkdir $(WEBROOT)/profile/images
	-chown dubya:webadmin $(WEBROOT)/home_page/audios
	-chmod 775 $(WEBROOT)/home_page/audios
	-chown dubya:webadmin $(WEBROOT)/home_page/images
	-chmod 775 $(WEBROOT)/home_page/images
	-chown dubya:webadmin $(WEBROOT)/home_page/comments
	-chmod 775 $(WEBROOT)/home_page/comments
	-chown dubya:webadmin $(WEBROOT)/profile/images
	-chmod 775 $(WEBROOT)/profile/images

clean:
	rm -rf $(WEBROOT)/*
	rm -rf $(INCLUDES)/*
