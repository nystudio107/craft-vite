TAG?=14-alpine
CONTAINER?=$(shell basename $(dir $(CURDIR)))-docs
DOCKERRUN=docker container run \
	--name ${CONTAINER} \
	--rm \
	-p 3002:3002 \
	-t \
	-v `pwd`:/app \
	${CONTAINER}:${TAG}
DOCSDEST?=../../../sites/nystudio107/web/docs/vite

.PHONY: docker build dev install update npm

docker:
	docker build \
		. \
		-t ${CONTAINER}:${TAG} \
		--build-arg TAG=${TAG} \
		--no-cache
build: docker install update
	${DOCKERRUN} \
		run docs:build
	rm -rf ${DOCSDEST}
	mv ./docs/.vitepress/dist ${DOCSDEST}
dev: docker install
	${DOCKERRUN} \
		run docs:dev
install: docker
	${DOCKERRUN} \
		install
update: docker
	${DOCKERRUN} \
		update
npm: docker
	${DOCKERRUN} \
		$(filter-out $@,$(MAKECMDGOALS))
%:
	@:
# ref: https://stackoverflow.com/questions/6273608/how-to-pass-argument-to-makefile-from-command-line
