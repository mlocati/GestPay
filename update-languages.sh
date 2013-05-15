xgettext --package-name=GestPay --default-domain=messages --output-dir=languages --output=messages.pot --language=PHP --from-code=UTF-8 --add-comments=i18n --keyword --keyword=t:1 --no-escape --indent --add-location --no-wrap GestPay.php GestPayCurrency.php GestPayException.php GestPayLanguage.php

msgmerge --update --no-fuzzy-matching --previous --lang=it --force-po --indent --add-location --no-wrap languages/it/messages.po languages/messages.pot
