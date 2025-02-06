# Scalable, Fault Tolerant eCommere Application

Built with micro-services:

- user service - handles login and token validation
- product service - handle product listing
- order service - processes orders
- payment service - processes payments
- api-gateway service - public facing service that will route all the requests


## Authentication and Authorization 

All the services are stateless and they accept a JWT token. 

Before doing any work, they will ask the user-service to validate the JWT token
and extract the payload: user, user roles and others. 

To get a token, the user service has a publicly available endpoint: /users/api/login
that takes an `email` and `password` and if it can authenticate the user will
return a JWT access token. 

Services are not publicly accessible. They can only be called via the api-gateway.

The api-gateway authenticates itself with a secret key passed as a header.

The services authenticate to each other also with a secret key that is passed as a 
header. 

## Why Micro Services

They are stateless, so they are easy to test.

They are decoupled. Each one service can be worked on independently, and even
in a different language all together. And they can be scaled up and down
independently. 

## Challenges

- Monitoring the system
- When something goes wrong - how do we find out why? and where?
