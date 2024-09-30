
WEBROOT := /srv/http

all:
	cp -r html/* $(WEBROOT)
	cp -r css $(WEBROOT)
	cp -r js $(WEBROOT)
	cp -r img $(WEBROOT)

clean:
	rm -rf $(WEBROOT)/*
