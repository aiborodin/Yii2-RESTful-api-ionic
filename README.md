Yii2 REST API
-------------------
It is a a RESTful API with Yii2 developed for my Ionic mobile application. It uses [Yii2-Micro](https://github.com/hoaaah/yii2-micro) approach so it will be lightweight and easy to deploy.

# Directory Structure

Directory structure is a little bit different from Yii2.

      config/             contains application configurations
      controllers/        contains Web controller classes
      migration/          contains list of your migration files
      models/             contains model classes
      modules/            contains your rest-api versioning (based on modules)
      vendor/             contains dependent 3rd-party packages
      web/                contains the entry script and Web resources

This template uses modules as versioning pattern. Every version of API saved in a module. This template already has v1 module, so it means if consumer wants to use v1 API, he can access `https://your-api-url/v1/endpoint`.


# API Scenario
## Supported Authentication
Support for 3 most used authentication.

1. HTTP Basic Auth:  the access token is sent as the username. This should only be used when an access token can be safely stored on the API consumer side. For example, the API consumer is a program running on a server.
2. Query parameter: the access token is sent as a query parameter in the API URL, e.g., https://example.com/users?access-token=xxxxxxxx. Because most Web servers will keep query parameters in server logs, this approach should be mainly used to serve JSONP requests which cannot use HTTP headers to send access tokens.
3. OAuth 2: the access token is obtained by the consumer from an authorization server and sent to the API server via HTTP Bearer Tokens, according to the OAuth2 protocol.

## API versioning
This template give you versioning scenario based on module application. In Yii2 a module are self-contained software units that consist of model, views, controllers and other supporting components. This template already have v1 module, it means all of endpoint for API v1 created in this module. When you publish a new API version (that break backward compatibility / BBC), you can create a new module. For more information create a module, you can visit this [Yii2 Guide on Creating Module](https://www.yiiframework.com/doc/guide/2.0/en/structure-modules).

