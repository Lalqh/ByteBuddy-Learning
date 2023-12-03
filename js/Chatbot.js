//Ejecutar Chatbot con la Api de Telegrama
//npm install node-telegram-bot-api
//cd js
//node Chatbot.js
const TelegramBot = require("node-telegram-bot-api");
const token = "6562552232:AAGE-0G2M5K9KAlkiTHn9JgLRkhNYW4YgXs";

const bot = new TelegramBot(token, { polling: true });

const citas = [];

function mostrarMenu(chatId) {
  const mensajeMenu = `
    ¿Cómo puedo ayudarte hoy?
    1. /agendarcita - Agendar una cita.
    2. /eliminarcita - Eliminar una cita.
    3. /buscarcita - Buscar una cita por ID.
    4. /foros - Visitar nuestros foros.
  `;
  bot.sendMessage(chatId, mensajeMenu, { parse_mode: "Markdown" });
}

bot.onText(/\/start/, (msg) => {
  const chatId = msg.chat.id;

  const mensajeInicio = `
    ¡Bienvenido a ByteBuddy Learning!

    ByteBuddy Learning es una empresa comprometida con brindar educación de alta calidad en programación y tecnología.

    📚 **Nuestra Misión:**
    Empoderar a individuos y organizaciones a través de la educación en tecnología.

    🏫 **Historia:**
    Fundada en 2013, hemos ofrecido cursos presenciales en Guadalajara, Jalisco, y ahora estamos emocionados de lanzar nuestra plataforma de cursos en línea.

    🔍 **Procesos Afectados:**
    - Profesores grabarán y subirán sus clases.
    - Evaluaciones serán en línea.
    - Evidencias de trabajos en la plataforma.
    - Nuevos profesores y asesores.

    🌐 **Nuestra Plataforma en Línea:**
    - Acceso global.
    - Cursos de Python, JavaScript, desarrollo web, ciencia de datos, IA, y más.
    - Contenido actualizado y práctico.

    💼 **Compromiso:**
    Formar la próxima generación de programadores y profesionales de la tecnología.
  `;

  bot.sendMessage(chatId, mensajeInicio, { parse_mode: "Markdown" });
  mostrarMenu(chatId);
});

bot.onText(/\/agendarcita/, (msg) => {
  const chatId = msg.chat.id;
  bot.sendMessage(chatId, "Estas seguro que quieres agendar una cita: ");
  bot.once("text", (response) => {
    if (response.text.toLowerCase() === "si") {
      bot.sendMessage(chatId, "1. Tu ID:");
      bot.once("text", (idMsg) => {
        const userId = idMsg.text;
        bot.sendMessage(chatId, "2. Tu Nombre:");
        bot.once("text", (nombreMsg) => {
          const nombre = nombreMsg.text;

          bot.sendMessage(chatId, "3. Motivo de la Cita:");
          bot.once("text", (motivoMsg) => {
            const motivo = motivoMsg.text;

            bot.sendMessage(chatId, "4. Nombre del Curso:");
            bot.once("text", (cursoMsg) => {
              const curso = cursoMsg.text;

              bot.sendMessage(chatId, "5. Nombre del Docente:");
              bot.once("text", (docenteMsg) => {
                const docente = docenteMsg.text;

                bot.sendMessage(chatId, "6. Fecha (Formato MM-DD-AAAA):");
                bot.once("text", (fechaMsg) => {
                  const fecha = fechaMsg.text;
                  const nuevaCita = {
                    id: userId,
                    nombre,
                    motivo,
                    curso,
                    docente,
                    fecha,
                  };

                  citas.push(nuevaCita);

                  bot.sendMessage(
                    chatId,
                    "Cita agendada con éxito. ¿Cómo más puedo ayudarte?"
                  );
                  mostrarMenu(chatId);
                });
              });
            });
          });
        });
      });
    } else if (response.text.toLowerCase() === "no") {
      bot.sendMessage(chatId, "Muy bien. ¿Cómo más puedo ayudarte?");
      mostrarMenu(chatId);
    } else {
      bot.sendMessage(chatId, "Opción no válida. ¿Cómo más puedo ayudarte?");
      mostrarMenu(chatId);
    }
  });
});

bot.onText(/\/eliminarcita/, (msg) => {
  const chatId = msg.chat.id;

  bot.sendMessage(chatId, "Estas seguro que quieres eliminar una cita: ");

  bot.once("text", (response) => {
    if (response.text.toLowerCase() === "si") {
      bot.sendMessage(
        chatId,
        "Por favor, ingresa tu ID para buscar y eliminar la cita:"
      );
      bot.once("text", (idMsg) => {
        const userId = idMsg.text;
        const indiceCita = citas.findIndex((cita) => cita.id === userId);
        if (indiceCita !== -1) {
          const citaEliminada = citas.splice(indiceCita, 1)[0];
          const mensajeCitaEliminada = `
            Cita eliminada:
            - ID: ${citaEliminada.id}
            - Nombre: ${citaEliminada.nombre}
            - Motivo: ${citaEliminada.motivo}
            - Curso: ${citaEliminada.curso}
            - Docente: ${citaEliminada.docente}
            - Fecha: ${citaEliminada.fecha}
          `;
          bot.sendMessage(chatId, mensajeCitaEliminada, {
            parse_mode: "Markdown",
          });
        } else {
          bot.sendMessage(
            chatId,
            "No se encontró una cita con el ID proporcionado."
          );
        }
        mostrarMenu(chatId);
      });
    } else if (response.text.toLowerCase() === "no") {
      bot.sendMessage(chatId, "Muy bien. ¿Cómo más puedo ayudarte?");
      mostrarMenu(chatId);
    } else {
      bot.sendMessage(chatId, "Opción no válida. ¿Cómo más puedo ayudarte?");
      mostrarMenu(chatId);
    }
  });
});

bot.onText(/\/buscarcita/, (msg) => {
  const chatId = msg.chat.id;

  bot.sendMessage(chatId, "Por favor, ingresa tu ID para buscar la cita:");

  bot.once("text", (idMsg) => {
    const userId = idMsg.text;

    const citaEncontrada = citas.find((cita) => cita.id === userId);

    if (citaEncontrada) {
      const mensajeCitaEncontrada = `
        Cita encontrada:
        - ID: ${citaEncontrada.id}
        - Nombre: ${citaEncontrada.nombre}
        - Motivo: ${citaEncontrada.motivo}
        - Curso: ${citaEncontrada.curso}
        - Docente: ${citaEncontrada.docente}
        - Fecha: ${citaEncontrada.fecha}
      `;
      bot.sendMessage(chatId, mensajeCitaEncontrada, {
        parse_mode: "Markdown",
      });
    } else {
      bot.sendMessage(
        chatId,
        "No se encontró una cita con el ID proporcionado."
      );
    }
    mostrarMenu(chatId);
  });
});

bot.onText(/\/foros/, (msg) => {
  const chatId = msg.chat.id;
  const forosLink = "https://discord.gg/6qrdUSKfqJ";
  bot.sendMessage(chatId, `Visita nuestros foros en: ${forosLink}`);
});
