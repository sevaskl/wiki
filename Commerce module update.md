После обновления модуля требуется добавить след. строки:

1. \var\www\html\schmidt-new\web\modules\contrib\commerce\modules\order\commerce_order.workflows.yml

```
...
my_module_fulfillment_processing:
  id: my_module_fulfillment_processing
  group: commerce_order
  label: 'Fulfillment, with processing'
  states:
    draft:
      label: Draft
    ordered:
      label: Ordered
    paid:
      label: Waiting for Payment      
    processing:
      label: Processing order
    shipped:
      label: Shipped
    completed:
      label: Completed
    canceled:
      label: Canceled
  transitions:
    place:
      label: 'Place order'
      from: [draft]
      to: ordered
    ordered:
      label: 'Ordered Viewed'
      from: [ordered]
      to: paid
    paid:
      label: 'Paid'
      from: [paid]
      to: processing 
    processing:
      label: 'Order Processed '
      from: [processing]
      to: shipped
    shipped:
      label: 'Complete'
      from: [shipped]
      to: completed
    cancel:
      label: 'Cancel order'
      from: [draft,paid, processing,  shipped]
      to:   canceled      
```
