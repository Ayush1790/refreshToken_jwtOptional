<?php

namespace assets;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;
use Phalcon\Cache\Adapter\Stream;
use Phalcon\Storage\SerializerFactory;

class Locale extends Injectable
{
    /**
     * @return NativeArray
     */
    public function getTranslator(): NativeArray
    {
        // Ask browser what is the best language
        $language = $this->request->get('locale');
        if (!isset($language)) {
            $language = 'en_US';
        }
        if ($this->cache->has('my-key') && $this->cache->get('my-key') == $language) {
            $lang = $this->key->get('my-key');
            return $factory->newInstance(
                'array',
                [
                    'content' => $lang,
                ]
            );
        } else {
            $messages = [];
            $translationFile = APP_PATH . '/messages/' . $language . '.php';
            if (true !== file_exists($translationFile)) {
                $translationFile = APP_PATH . '/messages/en_US.php';
            }
            require $translationFile;
            $interpolator = new InterpolatorFactory();
            $factory      = new TranslateFactory($interpolator);
            $this->cache->set('my-key', $messages);
            return $factory->newInstance(
                'array',
                [
                    'content' => $messages,
                ]
            );
        }
    }
}
