> [!WARNING]  
> ⚠️ This branch (`psr18`) introduces PSR-18 (HTTP Client) support.  
> The implementation is stable, but still evolving. Expect refinements prior to release.

---

### ✅ Integration Overview

| Backend                  | Status       | Notes                                                                                                    |
|--------------------------|--------------|----------------------------------------------------------------------------------------------------------|
| **Mistral**              | ✅ Complete | Allmost complete. last step, fine tuning on the way                                                      |
| **VLLM**                 | ✅ Complete | Fully functional                                                                                         |
| **Hugging Face**         | ✅ Complete | Includes: `inference`, `text-embeddings-inference`, `text-generation-inference`, `Datasets manipulation` |
| **Ollama**               | ✅ Complete | Fully functional                                                            |
| **llama.cpp**            | ✅ Complete | Fully functional                                                                    |
| **Anthropic**            | ✅ Complete | Fully functional                                                         |
| **Grok**                 | ✅ Complete | Fully functional                                                                       |
| **Gemini**               | ⏸ Deferred | Low demand – integration postponed for now                                                               

---

### 📘 Documentation Status

Full documentation is **currently in development**.

In the meantime, all major use cases — including request building, client configuration, and response handling — are illustrated via real-world examples in:

📁 [`examples/Clients`](https://github.com/partITech/php-mistral/tree/psr18/examples/Clients)

> These are **canonical examples**, directly mapped to each backend’s official API behavior.  
> You can rely on them today for actual integration and experimentation.

---

### 🛠️ Roadmap & Next Steps

- 🧪 PHPUnit-based unit testing
- 📚 Finalize and publish documentation
- 🧭 Gemini (optional, pending interest)

---

### 🤝 Contributors Welcome

The core is solid and ready for real-world testing. If you:

- want to test integrations in your own stack,
- find edge cases or inconsistencies,
- or would like to contribute to docs, adapters, or test coverage...

You're more than welcome to jump in 🙌

---

### 🚀 Get Started

- 📖 [Read the early docs](https://github.com/partITech/php-mistral/blob/psr18/doc/mistral-client/menu.md)
- 📂 [See real-world usage](https://github.com/partITech/php-mistral/tree/psr18/examples/Clients) – every backend is covered 🧰
