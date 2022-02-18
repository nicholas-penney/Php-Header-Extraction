# PHP Header Extration

Returned JSON object echoed back from PHP to AJAX (other methods are available) is of the structure:

```bash
success(response) {
	var response = {
		Headers: { ... },
		Status: { Code: 200, Message: "OK" },
		data: { ... }
	}
}
```

## Note:

Headers is only echoed back for debugging. Proper implementation is for the Headers object to be used within PHP for it's own internal logic e.g. for Caching control.
