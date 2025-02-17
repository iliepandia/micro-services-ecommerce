# Scalable, Fault Tolerant, Micro-Services eCommere Application

## Intro

This is a DEMO project, exploring the micro-services architecture. It is a very 
basic application with simple auth rules. 

The purpose is not as much the ecommerce side, but rather how micro-services
interact, how authorization works, how we monitor logs, and so on.

## Details

Built with the following micro-services:

- `user service` - handles login and token validation
- `product service` - handle product listing
- `order service` - processes orders
- `payment service` - processes payments
- `api-gateway service` - public facing service that will route all the requests


## Authentication and Authorization 

All the services are stateless, and they accept a JWT token. 

Before doing any work, they will ask the user-service to validate the JWT token
and extract the payload: user, user roles and others. 

To get a token, the user service has a publicly available endpoint: /users/api/login
that takes an `email` and `password` and if it can authenticate the user will
return a JWT access token. 

Services are not publicly accessible. They can only be called via the api-gateway.

The api-gateway authenticates itself with a secret key passed as a header.

The services authenticate to each other also with a secret key that is passed as a 
header. 

Some of the endpoints are exposed to the public via the API gateway and others
are only to be used inside the micro-services network.

## Monitoring the services 

To monitor the system resource usage, I am using cAdvisor with a plant to then 
use that data into a Prometheus instance.

## Monitoring the Logs - Laravel Logs over ELK stack

I have added the so-called ELK stack. ElasticSearch, Logstash, Kibana.

- ElasticSearch will store the logs and make then searchable
- Logstash is what laravel will use to push the logs to ElasticSearch
- Kibana is the visualization tool to inspect those logs

Tutorials that have helped:
- [Deploying ELK inside docker](https://medium.com/@lopchannabeen138/deploying-elk-inside-docker-container-docker-compose-4a88682c7643 ) 
  getting ElasticSearch to work inside of Docker was a bit of challenge. The configuration has to be just right!
- [FileBeat ELK Stack](https://medium.com/@mehraien.arash/laravel-log-management-using-filebeat-elk-elastic-search-logstash-and-kibana-be7db5985bd6 )
  interesting to understand how the services connect together  

### Next steps for the logs 

Look like things have evolved and you're not supposed to push logs 
from Laravel straight into LogStash, but instead use something like Filebeat
and offload this log delivery to yet another service. 

While this adds one more service to the stack, it makes sense to use 
to avoid any back pressure from LogStash and looks like filebeat is
able to buffer logs, in case LogStash is not available for some reason.

## Why Micro Services

They are stateless, so they are easy to test.

They are decoupled. Each one service can be worked on independently, and even
in a different language all together. And they can be scaled up and down
independently.

## Challenges

- Monitoring the system (cAdvisor)
- When something goes wrong - how do we find out why? and where?
  - sent the logs into the ELK stack (ElasticSearch, Logstash and Kibana) 
- Generating URLs from inside the service
- Passing the authorized user securely between the services
