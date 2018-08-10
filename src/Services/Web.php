<?php

namespace VestaAPI\Services;

trait Web
{
    /**
     * List Web Domains.
     *
     * @param $domain
     *
     * @return mixed
     */
    public function listEditWebDomain($domain)
    {
        $this->returnCode = 'no';
        $answer = $this->send('v-list-web-domain', $this->userName, $domain, 'json');

        $data = json_decode($answer, true);

        $ftpU = strpos($data[$domain]['FTP_USER'], ':');
        $ftpPath = strpos($data[$domain]['FTP_PATH'], ':');

        if ($ftpU !== false) {
            $ftAr = explode(':', $data[$domain]['FTP_USER']);
            $data[$domain]['FTP_USER'] = $ftAr;
        }
        if ($ftpPath !== false) {
            $ftpP = explode(':', $data[$domain]['FTP_PATH']);
            $data[$domain]['FTP_PATH'] = $ftpP;
        }

        return $data;
    }

    /**
     * List Web Domains.
     *
     * @return mixed
     */
    public function listWebDomain()
    {
        $this->returnCode = 'no';
        $answer = $this->send('v-list-web-domains', $this->userName, 'json');
        $data = json_decode($answer, true);

        return $data;
    }

    /**
     * Add Web/DNS/Mail Domain
     *
     * @param $user
     * @param $domain
     *
     * @return mixed
     */
    public function addFullDomain($user, $domain)
    {
        return $this->send('v-add-domain', $user, $domain);
    }

    /**
     * Add Web Domains.
     *
     * @param $domain
     * @param $ip
     *
     * @return mixed
     */
    public function addWebDomain($domain, $ip)
    {
        return $this->send('v-add-web-domain', $this->userName, $domain, $ip);
    }

    /**
     * Support DNS.
     *
     * @param $domain
     * @param $ip
     *
     * @return mixed
     */
    public function addDns($domain, $ip)
    {
        return $this->send('v-add-dns-domain', $this->userName, $domain, $ip);
    }

    /**
     * Support Mail.
     *
     * @param $domain
     *
     * @return mixed
     */
    public function addMail($domain)
    {
        return $this->send('v-add-mail-domain', $this->userName, $domain);
    }

    /**
     * Add domain aliases.
     *
     * @param $domain
     * @param $alias
     */
    public function addWebDomainAlias($domain, $alias)
    {
        $this->send('v-add-web-domain-alias', $this->userName, $domain, $alias, 'no');
    }

    /**
     * Support Alias DNS.
     *
     * @param $domain
     * @param $alias
     *
     * @return mixed
     */
    public function addDnsAlias($domain, $alias)
    {
        return $this->send('v-add-dns-on-web-alias', $this->userName, $domain, $alias, 'no');
    }

    /**
     * Delete www. alias if it wasn't found.
     *
     * @param $domain
     * @param $alias
     *
     * @return mixed
     */
    public function deleteWebDomainAlias($domain, $alias)
    {
        return $this->send('v-delete-web-domain-alias', $this->userName, $domain, $alias, 'no');
    }

    /**
     * Add FTP domain.
     *
     * @param $domain
     * @param $ftpUserName
     * @param $ftpPassword
     * @param $ftpPath
     *
     * @return mixed
     */
    public function addFtpDomain($domain, $ftpUserName, $ftpPassword, $ftpPath)
    {
        return $this->send('v-add-web-domain-ftp', $this->userName, $domain, $ftpUserName, $ftpPassword,
            $ftpPath);
    }

    /**
     * Add proxy support.
     *
     * @param $domain
     * @param $ext
     *
     * @return mixed
     */
    public function addDomainProxy($domain, $ext)
    {
        return $this->send('v-add-web-domain-proxy', $this->userName, $domain, '', $ext, 'no');
    }

    /**
     * Delete domain.
     *
     * @param $domain
     *
     * @return mixed
     */
    public function deleteDomain($domain)
    {
        return $this->send('v-delete-domain', $this->userName, $domain);
    }

    /**
     * Chane dns domain IP.
     *
     * @param $domain
     * @param $ip
     *
     * @return mixed
     */
    public function changeWebDomainIp($domain, $ip)
    {
        return $this->send('v-change-web-domain-ip', $this->userName, $domain, $ip, 'no');
    }

    /**
     * Delete web domain.
     *
     * @param $domain
     * @param $ftpUserName
     *
     * @return mixed
     */
    public function deleteWebDomain($domain, $ftpUserName)
    {
        return $this->send('v-delete-web-domain-ftp', $this->userName, $domain, $ftpUserName);
    }

    /**
     * Change web domain.
     *
     * @param $domain
     * @param $ftpUserName
     * @param $ftpPath
     *
     * @return mixed
     */
    public function changeWebDomain($domain, $ftpUserName, $ftpPath)
    {
        return $this->send('v-change-web-domain-ftp-path', $this->userName, $domain, $ftpUserName,
            $ftpPath);
    }

    /**
     * Change ftp password.
     *
     * @param $domain
     * @param $ftpUserName
     * @param $password
     *
     * @return mixed
     */
    public function changeFtpPassword($domain, $ftpUserName, $password)
    {
        return $this->send('v-change-web-domain-ftp-password', $this->userName, $domain, $ftpUserName,
            $password);
    }
}
