# task in related file TASK.md


# installation
* bash
```bash
echo '127.0.0.1 mintos-test-task.local.net' | sudo tee -a /etc/hosts
git clone git@github.com:Neznajki/mintos-test-task.git
cd mintos-test-task
./connect-docker.sh
composer install
./bin/console c:cl
./bin/console d:m:m
./bin/console ap:i
./bin/console ap:w
```

