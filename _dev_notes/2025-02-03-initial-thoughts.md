- services need to be separate projects completely, even if tied together by the same docker file.
  - otherwise it completely confuses PHPStorm. And the idea is anyway that these services need
    be independent. 

- the initial setup files from ChatGPT were a mess
- There is no Kernel defined in a default laravel project, which is surprising!! 
   - so how do we define the default midelware for everyone
- How will I share common code between the project files?! Do I go a package approach with the 
  package being from the local driver

- If the API Gateway key is leaked then services become publicly accessible so I still need to remove 
  their ports

- Adding that extra header from the nginx api-gateway worked nice 

- Each service in the current config will have to validate the JWT token and parse it to respond to
  a request. Nginx is not doing anything other that routing

- How will I serve a front end from nginx?! will that be a JS file?! and where do I get the static
  resources from? Interesting challenges...