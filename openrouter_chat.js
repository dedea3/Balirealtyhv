import { OpenRouter } from "@openrouter/sdk";
import dotenv from "dotenv";

// Load environment variables from .env
dotenv.config();

const OPENROUTER_API_KEY = process.env.OPENROUTER_API_KEY || "MASUKKAN_API_KEY_DISINI";

if (OPENROUTER_API_KEY === "MASUKKAN_API_KEY_DISINI") {
  console.warn("AWAS: OPENROUTER_API_KEY tidak ditemukan di .env. Menggunakan placeholder.");
}

const openrouter = new OpenRouter({
  apiKey: OPENROUTER_API_KEY
});

async function main() {
  console.log("Menghubungkan ke OpenRouter (GLM-4.5-Air Free)... \n");

  try {
    const stream = await openrouter.chat.send({
      model: "z-ai/glm-4.5-air:free",
      messages: [
        {
          "role": "system",
          "content": "You are a helpful travel assistant for Bali Realty Holidays."
        },
        {
          "role": "user",
          "content": "Halo, berikan rekomendasi villa di Seminyak yang bagus untuk keluarga."
        }
      ],
      stream: true
    });

    for await (const chunk of stream) {
      const content = chunk.choices[0]?.delta?.content;
      if (content) {
        process.stdout.write(content);
      }
    }
    console.log("\n\n--- Selesai ---");
  } catch (error) {
    console.error("Gagal menghubungi OpenRouter:", error.message);
  }
}

main();
