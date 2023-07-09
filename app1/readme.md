# Readme

## App1 Summary

App1 is a simple User Crud.

### Architecture

Base for this application was MVC improved by CQRS assumptions. Every feature does only one thing.  (Exceptions may
occur in controllers, because in order to follow REST standards. Create or Update returns the resource).

In order to avoid binding application with framework or external tools I tried most of all to use interfaces which
will hide dependencies to for example doctrine entity manager.

As **the lesser evil** and keeping the simplicity of application, I used doctrine entities as models. For example
User entity has encapsulate inside logic for update.

Folder structure is organized in **pack-by-feature** way, to make easier to organize dependencies with high binding
to feature.

The exception from **pack-by-feature** is **shared** folder, because **shared** is a toolbox with tools to use in
feature, so for better organizing they are **packed-by-type**

### Features list

User management

- Create
- Remove
- Read user data
- Update user
- Index users

Almost every feature emits an event which is pushed to RabbitMq queue via **Symfony/Messenger** event dispatcher.
