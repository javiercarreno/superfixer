export ROOT_DIR=${PWD}
all: help

help:
		@echo "Superfixer utility"
		@echo ""
		@echo " clean           removes the link from your path"
		@echo " install         reinstalls the composer dependencies and creates the link in the path"

clean:
		@rm -f /usr/local/bin/superfix
		@echo 'Superfixer removed from path succesfully'

install:
		@echo 'Installing dependencies'
		@composer install
		@chmod +x superfixer
		@ln -s ${ROOT_DIR}/superfixer /usr/local/bin/superfix
		@echo 'Superfixer installed succesfully'


.PHONY: all help clean install run
