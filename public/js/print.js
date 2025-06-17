window.printElement = function (selector, options = {}) {
    const element = document.querySelector(selector);
    if (!element) {
        console.error("Element not found:", selector);
        return;
    }

    const iframe = document.createElement("iframe");
    iframe.style.position = "fixed";
    iframe.style.right = "0";
    iframe.style.bottom = "0";
    iframe.style.width = "0";
    iframe.style.height = "0";
    iframe.style.border = "0";
    document.body.appendChild(iframe);

    const doc = iframe.contentWindow.document;
    doc.open();

    const styles = [
        ...document.querySelectorAll('link[rel="stylesheet"], style'),
    ]
        .map((style) => style.outerHTML)
        .join("");

    doc.write(`
      <html>
        <head>
          <title>${options.title || "Print"}</title>
          ${styles}
          ${options.extraStyle ? `<style>${options.extraStyle}</style>` : ""}
        </head>
        <body>
          ${element.outerHTML}
        </body>
      </html>
    `);
    doc.close();

    iframe.onload = () => {
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            document.body.removeChild(iframe);
        }, 100);
    };
};
