
WEBROOT := /srv/http
INCLUDES := /srv/includes

all:
	cp -r root/* $(WEBROOT)
	cp scripts.php $(INCLUDES)

clean:
	rm -rf $(WEBROOT)/*
	rm -rf $(INCLUDES)/*
