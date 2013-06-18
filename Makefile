TARGET_DIR = build

build: prepare main themes

prepare: clean
	@mkdir $(TARGET_DIR)

main:
	cp -R src/* $(TARGET_DIR)/

themes: themes_default

themes_default:
	@mkdir -p $(TARGET_DIR)/themes/default
	@touch src/themes/default/all.src.css
	@(cd src/themes/default && find blocks -name '*.css' -print0 | xargs -0 printf "@import url(%s);\n" >> all.src.css)
	@borschik -t css -m no -i src/themes/default/all.src.css -o $(TARGET_DIR)/themes/default/all.css
	@rm src/themes/default/all.src.css
	@csso $(TARGET_DIR)/themes/default/all.css $(TARGET_DIR)/themes/default/all.min.css

clean:
	@if [ -d $(TARGET_DIR) ]; then rm -rf $(TARGET_DIR); fi

.PHONY: build clean prepare main themes themes_default
