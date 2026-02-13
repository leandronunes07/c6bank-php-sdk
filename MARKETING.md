# 📢 Kit de Marketing & Lançamento (v1.0.0)

Aqui estão textos prontos para você copiar e colar nas redes sociais.

---

## 🟦 LinkedIn (Post Institucional)

**Título:** Lancei o SDK PHP mais robusto para o C6 Bank! 🚀

Fala, rede! 👋

Hoje estou liberando a versão **1.0.0** do **C6 Bank PHP SDK** (Unofficial).
Depois de muuuita dor de cabeça integrando APIs bancárias na unha, decidi criar uma solução definitiva e open-source para a comunidade PHP.

O que tem de diferente? 🤔
Não é só um wrapper de API. É uma **solução Enterprise-Ready**:

✅ **Cache Inteligente**: O SDK gerencia tokens OAuth2 automaticamente (PSR-16), evitando Rate Limits.
✅ **Observabilidade**: Sistema de Logs nativo (PSR-3) para você saber exatamente o que está acontecendo.
✅ **Resiliência**: Retry automático. Se o C6 piscar (erro 5xx), o SDK tenta de novo sem quebrar sua aplicação.
✅ **Fail-Fast**: Validação de CPF/CNPJ e UUIDs direto no código, antes de gastar request.

Suporte completo para:
- 💠 PIX (Cobrança, Webhooks, Location)
- 📝 Boletos (Emissão, PDF, Cancelamento)
- 🛒 Checkout & C6 Pay
- 🏦 Extratos e Agendamentos

O projeto é **Open Source (MIT)** e está disponível no Packagist.
🔗 **GitHub:** https://github.com/leandronunes07/c6bank-php-sdk
📦 **Composer:** `composer require leandronunes07/c6bank-php-sdk`

Feedbacks e PRs são super bem-vindos! Vamos elevar a régua do PHP no Brasil. 🇧🇷🐘

#PHP #Laravel #C6Bank #OpenSource #DevCommunity #Fintech #API

---

## ⬛ Twitter / X (Thread)

**Tweet 1:**
Acabei de lançar o SDK PHP (Unofficial) para o C6 Bank! 🇧🇷🚀
Se você precisa integrar PIX, Boletos ou C6 Pay, essa lib vai salvar sua vida.
Tem Cache de Auth, Retry automático e Logs nativos.
📦 `composer require leandronunes07/c6bank-php-sdk`
👇 Thread com detalhes!

**Tweet 2:**
🔧 **O que resolvemos?**
Chega de implementar cURL na mão ou brigar com mTLS.
O SDK abstrai toda a complexidade de certificados e OAuth2.
É só configurar e usar: `$c6->pix()->cob()->create(...)`

**Tweet 3:**
🛡️ **Enterprise Ready**
O foco foi qualidade.
- PSR-12 (Code Style)
- PSR-3 (Logs)
- PSR-16 (Cache)
- DTOs para tudo (Adeus arrays mágicos!)
- GitHub Actions (CI/CD)

**Tweet 4:**
🔗 **Link do Repo:**
https://github.com/leandronunes07/c6bank-php-sdk

Deixa uma ⭐ lá se ajudar no seu projeto!
Feedbacks são bem-vindos. #PHP #Laravel #C6Bank

---

## 💬 WhatsApp / Telegram (Grupos de Dev)

Fala galera!
Acabei de publicar um SDK PHP para o **C6 Bank** completasso.
Quem estiver mexendo com integração bancária (PIX, Boleto, Webhook), dá uma olhada.
Fiz com suporte a **Cache de Token**, **Retry** no Guzzle e **Logs PSR-3**.
Tá bem robusto pra produção.
GitHub: https://github.com/leandronunes07/c6bank-php-sdk

---

## 📧 Email (Para Clientes/Parceiros)

**Assunto:** Nova Integração Bancária C6 Bank Disponível

Olá,
Gostaria de informar que finalizamos o desenvolvimento do módulo de integração com o C6 Bank.
Desenvolvemos um SDK proprietário (agora open-source) que garante maior estabilidade nas transações via PIX e Boletos, com tratamento automático de falhas e monitoramento detalhado.
Isso trará mais confiabilidade para o sistema de pagamentos.

Qualquer dúvida, estou à disposição.
Att,
**Leandro Nunes**
Agência Taruga
