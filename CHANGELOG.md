# Delivery Service Changelog

## v0.2.0

- Removes the `Message` interface and implementations
- Converts the library to use PSR-4 autoloading directory structure

## v0.1.0

- Initial release
- Includes interfaces for `Transmitter`, `Receiver`, `Mediator`, `Message`, and `MessageQueue`
- Includes an abstraction over promises and promisors with the `Receipt`, `MessageReceiptPromisor`, and `DeliveryResults`
- Implementations for a Transmitter, Receiver, MessageQueue