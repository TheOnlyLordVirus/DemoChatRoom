<?php
    class DatabaseController
    {
        private $connection = null;

        function __construct()
        {
            $DATABASE_HOST = "localhost";
            $DATABASE_USER = "admin";
            $DATABASE_PASS = "JeffStar";
            $DATABASE_NAME = "SAMPLE_DB";

            $this->connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

            if (mysqli_connect_errno())
            {
                return 'Failed to connect to MySQL: ' . mysqli_connect_error();
            }
        }

        /**
         * username, password
         * @param $parameters
         * @return bool
         */
        public function sendCommand($username, $password, $command, $parameters = '{}')
        {
            $USER_ACCOUNT = $this->stripAllSymbols($username);
            $USER_PASSWORD = $this->stripSomeSymbols($password);

            if ($this->login(['username' => $USER_ACCOUNT, 'password' => $USER_PASSWORD]))
            {
                switch ($command)
                {
                    case 'login':
                        return true;
                        break;

                    case 'add_user':
                        return $this->addUser(json_decode($parameters, true));
                        break;

                    case 'delete_user':
                        return $this->removeUser(json_decode($parameters, true));
                        break;

                    case 'send_message':
                        return $this->sendMessage(json_decode($parameters, true));
                        break;

                    case 'get_message':
                        return $this->getChatLog();
                        break;

                    case 'get_uid':
                        return $this->getUserId(json_decode($parameters, true));
                        break;

                    default:
                    return false;
                }
            }
        }

        /**
         * username, password
         * @param $parameters
         * @return bool
         */
        private function addUser($parameters)
        {
            $username = $this->stripAllSymbols($parameters['username']);
            $password = $this->stripSomeSymbols($parameters['password']);

            if ($add_user_query = $this->connection->prepare('call addUser(?, ?)'))
            {
                $add_user_query->bind_param('ss', $email, $username);
                $add_user_query->execute();
                $add_user_query->store_result();

                if($add_user_query->affected_rows > 0)
                {
                    return true;
                }
            }

            return false;
        }

        /**
         * email, username, password
         * @param $parameters
         * @return bool
         */
        private function removeUser($parameters)
        {
            $username = $this->stripAllSymbols($parameters['username']);
            $password = $this->stripSomeSymbols($parameters['password']);

            if ($remove_user_query = $this->connection->prepare('DELETE FROM USER WHERE USER_NAME = ? AND USER_PASS = ?'))
            {
                $remove_user_query->bind_param('ss', $username, $password);
                $remove_user_query->execute();
                $remove_user_query->store_result();

                if($remove_user_query->affected_rows > 0)
                {
                    return true;
                }
            }

            return false;
        }

        /**
         * Username, password
         * @param $parameters
         * @return bool
         */
        private function login($parameters)
        {
            $username = $this->stripAllSymbols($parameters['username']);
            $password = $this->stripSomeSymbols($parameters['password']);

            if ($login_query = $this->connection->prepare('SELECT USER_ID, USER_PASS FROM USER WHERE USER_NAME = ? AND USER_PASS = ?'))
            {
                $login_query->bind_param('ss', $username, $password);
                $login_query->execute();
                $login_query->store_result();

                if($login_query->num_rows > 0)
                {
                    return true;
                }
            }

            return false;
        }

        /**
         * userid, Message
         * @param $parameters
         * @return bool
         */
        private function sendMessage($parameters)
        {
            $userid = $this->stripAllSymbols($parameters['userid']);
            $message = $this->stripSomeSymbols($parameters['message']);

            if ($chat_query = $this->connection->prepare('call addMessage(?, ?)'))
            {
                $chat_query->bind_param('ss', $userid, $message);
                $chat_query->execute();
                $chat_query->store_result();

                if($chat_query->num_rows > 0)
                {
                    return true;
                }
            }

            return false;
        }

        /**
         * Return chat logs
         * @return html or bool
         */
        private function getChatLog()
        {
            if ($chat_query = $this->connection->prepare('SELECT * FROM VIEW_CHAT_HISTORY'))
            {
                $chat_query->execute();
                $chat_query->store_result();
                $chat_query->bind_result($chat_user, $chat_message, $chat_date);

                if($chat_query->num_rows > 0)
                {
                    $html = "<tr><th>User Name</th><th>Message</th><th>Date</th></tr>";

                    while($chat_query->fetch())
                    {
                        $html .= '<tr class="chatRow"><td class="userName">' . $chat_user . '</td><td class="userText">' . $chat_message . '</td><td class="messageDate">'. $chat_date . '</td></tr>';
                    }

                    return $html;
                }
            }

            return false;
        }

        /**
         * Return userId
         * @return string or bool
         */
        private function getUserId($parameters)
        {
            $username = $this->stripAllSymbols($parameters['username']);
            $password = $this->stripSomeSymbols($parameters['password']);

            if ($uid_query = $this->connection->prepare('select USER_ID from USER where USER_NAME = ? AND USER_PASS = ?'))
            {
                $uid_query->bind_param('ss', $username, $password);
                $uid_query->execute();
                $uid_query->store_result();
                $uid_query->bind_result($return_uid);

                if($uid_query->num_rows > 0)
                {
                    $uid_query->fetch();
                    return $return_uid;
                }
            }

            return false;
        }


        /**
         * Extra SQLi Protection with regex
         * @param $inputStream
         * @return string
         */
        private function stripAllSymbols($inputStream)
        {
            $outputStreams = preg_replace('/[^0-9a-zA-Z]+/', '', $inputStream);
            return $outputStreams;
        }

        /**
         * Extra SQLi Protection with regex
         * @param $inputStream
         * @return string
         */
        private function stripSomeSymbols($inputStream)
        {
            $outputStreams = preg_replace('/[^0-9a-zA-Z.!@#$%^&*-_]+/', '', $inputStream);
            return $outputStreams;
        }
    }
?>