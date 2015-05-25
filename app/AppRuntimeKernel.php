<?php

class AppRuntimeKernel extends AppKernel
{
    /**
     * @var string
     */
    protected $runtimeDir;

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getCacheDir()
    {
        return $this->getRuntimeDir() . '/cache/' . $this->environment;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getLogDir()
    {
        return $this->getRuntimeDir() . '/logs';
    }

    /**
     * @return string
     */
    protected function getRuntimeDir()
    {
        if(null === $this->runtimeDir) {
            $runtimeDirConfigFile = __DIR__ . '/runtime_dir_config.php';
            if(is_file($runtimeDirConfigFile)) {
                $this->runtimeDir = require $runtimeDirConfigFile;
            } else {
                $this->runtimeDir = $this->rootDir;
            }
        }

        return $this->runtimeDir;
    }
}
