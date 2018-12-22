<?php

namespace Factory;

class Energomera126
{
    private const LIMIT_ERROR = 3;
    private $deviceNumber;
    private $address;
    private $service_port;
    private $socket;
    private $request;
    private $countErr;

    public function __CONSTRUCT(string $deviceNumber, string $address, int $service_port)
    {
        $this->deviceNumber = $deviceNumber;
        $this->address = $address;
        $this->service_port = $service_port;
        $this->request = "EMC !126_" . $this->deviceNumber . "\r\n";
    }

    private function connect(): void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>3, "usec"=>0));
		socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 3, 'usec' => 0)); 
        $result = socket_connect($this->socket, $this->address, $this->service_port);
        if ($result === false) {
            throw new \Exception("Connection failed!\n");
        }	
	}

    private function sendRequest(): void
    {
        $result = socket_write($this->socket, $this->request, strlen($this->request));
        if ($result === false) {
            throw new \Exception("Error sending request!\n");
        }
    }

    private function getResponse(): string
    {
        if ($response = socket_read($this->socket, 1024, PHP_BINARY_READ)) {
            socket_close($this->socket);
            return $response;
        } else {
            throw new \Exception("Error reading response!\n");
        }
    }
	
	 private function hexTo32Float(string $strHex): float
    {
        $v = hexdec($strHex);
        $x = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
        $exp = ($v >> 23 & 0xFF) - 127;
        return $x * pow(2, $exp - 23);
    }

    private function strToHexStr(string $str): string
    {
        if (strlen(dechex(ord($str))) === 1) {
            return "0" . dechex(ord($str));
        } else {
            return  dechex(ord($str));
        }
    }

    private function checkResponseErr(string $response): bool
    {
        $responseErr = $this->strToHexStr($response[8]) . $this->strToHexStr($response[9]);
        $responseErr .= $this->strToHexStr($response[10]) . $this->strToHexStr($response[11]);
        $responseErr .= $this->strToHexStr($response[12]) . $this->strToHexStr($response[13]);
        $responseErr .= $this->strToHexStr($response[14]) . $this->strToHexStr($response[15]);
       
        if ($responseErr === "80f0000000000000") {
            return true;
        } elseif ($responseErr === "0000000000000000") {
            return true;
        } else {
			//echo "Error stack: " . $responseErr . "\n";
            return false;
        }
    }

    private function parsingResponse(string $response): array
    {
        $results = [];
        $responceQ1 = $this->strToHexStr($response[23]) . $this->strToHexStr($response[22]);
        $responceQ1 .= $this->strToHexStr($response[20]) . $this->strToHexStr($response[21]);
        $q1 = $this->hexTo32Float($responceQ1);
        $results['q1'] = round($q1, 2);

        $responceP1 = $this->strToHexStr($response[27]) . $this->strToHexStr($response[26]);
        $responceP1 .= $this->strToHexStr($response[24]) . $this->strToHexStr($response[25]);
        $p1 = $this->hexTo32Float($responceP1);
        $results['p1'] = round($p1, 2);

        $responceT1 = $this->strToHexStr($response[31]) . $this->strToHexStr($response[30]);
        $responceT1 .= $this->strToHexStr($response[28]) . $this->strToHexStr($response[29]);
        $t1 = $this->hexTo32Float($responceT1);
        $results['t1'] = round($t1, 2);

        $responceQ2 = $this->strToHexStr($response[95]) . $this->strToHexStr($response[94]);
        $responceQ2 .= $this->strToHexStr($response[92]) . $this->strToHexStr($response[93]);
        $q2 = $this->hexTo32Float($responceQ2);
        $results['q2'] = round($q2, 2);

        $responceP2 = $this->strToHexStr($response[99]) . $this->strToHexStr($response[98]);
        $responceP2 .= $this->strToHexStr($response[96]) . $this->strToHexStr($response[97]);
        $p2 = $this->hexTo32Float($responceP2);
        $results['p2'] = round($p2, 2);

        $responceT2 = $this->strToHexStr($response[103]) . $this->strToHexStr($response[102]);
        $responceT2 .= $this->strToHexStr($response[100]) . $this->strToHexStr($response[101]);
        $t2 = $this->hexTo32Float($responceT2);
        $results['t2'] = round($t2, 2);

        return $results;
    }

    public function getResults(): array
    {
        $results = [];
        try {
            $this->connect();
            $this->sendRequest();
            usleep(100000);
            $response = $this->getResponse();
            if (!$this->checkResponseErr($response)) {
                $this->countErr++;
                if ($this->countErr < self::LIMIT_ERROR) {
                    sleep(1);
                    return $this->getResults();
                } else {
                    $results['Error'] = "Error limit exceeded!";
                    return $results;
                }
            } else {
                $results = $this->parsingResponse($response);
            }		
        } catch (\Exception $e) {
            echo $e->getMessage(), "\n";
            $results['Error'] = $e->getMessage();
            socket_close($this->socket);
        }
        return $results;
    }

    public function getDeviceNumber(): string
    {
        return $this->deviceNumber;
    }
}
