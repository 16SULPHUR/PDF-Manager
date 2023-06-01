const fs = require("fs");
const path = require("path");
const directory = "uploads";

const PDFMerger = require("pdf-merger-js");

var merger = new PDFMerger();

const mergepdfs = async (p1, p2, p3, p4, p5, p6, p7, p8) => {
  let pdfsArray = [p1, p2, p3, p4, p5, p6, p7, p8];

  for (let i = 0; i < pdfsArray.length; i++) {
    if (pdfsArray[i] != undefined) {
      await merger.add(pdfsArray[i]);
    }
  }

  // await merger.add(p1);
  // await merger.add(p2);
  // await merger.add(p3);
  // await merger.add(p4);
  // await merger.add(p5);
  // await merger.add(p6);
  // await merger.add(p7);
  // await merger.add(p8);

  // await merger.add(p1); //merge all pages. parameter is the path to file and filename.
  // await merger.add(p2); // merge only page 2

  await merger.save("public/merged.pdf"); //save under given name and reset the internal document

  // Export the merged PDF as a nodejs Buffer
  // const mergedPdfBuffer = await merger.saveAsBuffer();
  // fs.writeSync('merged.pdf', mergedPdfBuffer);


  fs.readdir(directory, (err, files) => {
    if (err) throw err;

    for (const file of files) {
      fs.unlink(path.join(directory, file), (err) => {
        if (err) throw err;
      });
    }
  });

};

module.exports = { mergepdfs };
