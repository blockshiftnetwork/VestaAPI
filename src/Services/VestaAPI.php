<?php

namespace VestaAPI\Services;

use GuzzleHttp\Client;
use VestaAPI\Exceptions\VestaExceptions;

class VestaAPI
{
    use BD, DNS, User, Web, Service, Cron, FileSystem;

    /**
     * return no|yes|json.
     *
     * @var string
     */
    public $returnCode = 'yes';

    /**
     * @var
     */
    private $userName = '';

    /**
     * @var string
     */
    private $key = '';

    /**
     * @var
     */
    private $host = '';

    /**
     * @param string $server
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function server($server = '')
    {
        if (empty($server)) {
            throw new \Exception('Server is not specified');
        }
        $allServers = config('vesta.servers');

        if (!isset($allServers[$server])) {
            throw new \Exception('Specified server not found in config');
        }

        if ($this->keysCheck($server, $allServers)) {
            throw new \Exception(
                'Specified server config does not contain host, user or key'
            );
        }

        $this->host = (string) $allServers[$server]['host'];
        $this->username = (string) $allServers[$server]['admin_user'];
        $this->key = (string) $allServers[$server]['admin_password'];

        return $this;
    }

    /**
     * @param string $server
     * @param array  $config
     *
     * @return bool
     */
    private function keysCheck($server, $config)
    {
        return !isset($config[$server]['admin_user']) ||
               !isset($config[$server]['host']) ||
               !isset($config[$server]['admin_password']);
    }
    
    /**
     * @param string $userName
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setCredentials($userName = '', $password = '')
    {
        if (empty($userName)) {
            throw new \Exception('Username is not specified');
        }
        $this->userName = $userName;

        if (empty($password)) {
            throw new \Exception('Password is not specified');
        }

        $this->key = $password;

        return $this;
    }

    /**
     * @param string $cmd
     *
     * @throws VestaExceptions
     *
     * @return string
     */
    public function send($cmd)
    {
        $postVars = [
            'user'       => $this->userName,
            'password'   => $this->key,
            'returncode' => $this->returnCode,
            'cmd'        => $cmd,
        ];
        $args = func_get_args();
        foreach ($args as $num => $arg) {
            if ($num === 0) {
                continue;
            }
            $postVars['arg'.$num] = $args[$num];
        }

        $client = new Client([
            'base_uri'    => 'https://'.$this->host.':8083/api/',
            'timeout'     => 10.0,
            'verify'      => false,
            'form_params' => $postVars,
        ]);

        $query = $client->post('index.php')
            ->getBody()
            ->getContents();

        if ($this->returnCode == 'yes' && $query != 0) {
            throw new VestaExceptions($query);
        }

        return $query;
    }
}
