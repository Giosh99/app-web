    <?php
    //   namespace app;
        
        use Ratchet\Server\IoServer;
      //  use /src/app ;
        require dirname(__DIR__) . '/vendor/autoload.php';

        $server = IoServer::factory(
            new Chat(),
            8080
        );
        $server->run();
    ?>