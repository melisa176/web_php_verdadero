const { exec } = require("child_process");
const fs = require("fs");

// Función para ejecutar un comando en la terminal
function startProject(directory) {
    return new Promise((resolve, reject) => {
        const process = exec(`cd ${directory} && npm start`, (error, stdout, stderr) => {
            if (error) {
                reject(error);
                return;
            }
            resolve(stdout);
        });

        process.stdout.on("data", (data) => {
            const match = data.match(/localhost:(\d+)/);
            if (match) {
                resolve(match[1]); // Retorna el puerto detectado
            }
        });

        process.stderr.on("data", (data) => {
            console.error(`Error en ${directory}: ${data}`);
        });
    });
}

// Función para actualizar el archivo HTML con los puertos correctos
async function updateHTML(port1, port2) {
    const htmlPath = "index.html"; // Ruta de tu HTML principal
    let htmlContent = fs.readFileSync(htmlPath, "utf8");

    // Reemplaza los enlaces antiguos con los puertos detectados
    htmlContent = htmlContent.replace(/http:\/\/localhost:\d+\//g, "")
        .replace('<li><a href="">React_practica</a></li>', `<li><a href="http://localhost:${port1}/">React_practica</a></li>`)
        .replace('<li><a href="">React-API</a></li>', `<li><a href="http://localhost:${port2}/">React-API</a></li>`);

    fs.writeFileSync(htmlPath, htmlContent, "utf8");
    console.log(`✅ HTML actualizado con React_practica en ${port1} y React-API en ${port2}`);
}

// Iniciar ambos proyectos y actualizar el HTML
(async () => {
    try {
        console.log("🚀 Iniciando React_practica...");
        const port1 = await startProject("React_nuevo/app-first") || "3000";

        console.log("🚀 Iniciando React-API...");
        const port2 = await startProject("react-api") || "3001";

        await updateHTML(port1, port2);
    } catch (error) {
        console.error("❌ Error al iniciar los proyectos:", error);
    }
})();
