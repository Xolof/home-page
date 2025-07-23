#!/usr/bin/bash

vendor/bin/phpcbf -ps app/ public/ 

vendor/bin/phpcs -ps app/ public/ 

vendor/bin/phpstan analyse

