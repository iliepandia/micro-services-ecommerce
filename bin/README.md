# cAdvisor to monitor the containers. 

Because I am running WSL2 on Windows, things were not very straight forward!

I had to create a new mount and configure cAdvisor to look into that folder.

```text
 --volume=/mnt/windows_docker/:/rootfs/var/lib/docker:ro  
```

## cAdvisor UI

http://localhost:8080

## Starting and stopping

I have made some handy scripts for that:

- `bin/start-cadvisor`
- `bin/stop-cadvisor`

## References

https://github.com/vacp2p/wakurtosis/issues/58

And commands I had to run to make the mount work

```shell
sudo mkdir /mnt/windows_docker
sudo mount -t drvfs '\\wsl$\docker-desktop-data\data\docker' /mnt/windows_docker
```

Note: If wsl$ does not work, then try wsl.localhost


