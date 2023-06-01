const express = require("express");
const path = require("path");
const app = express();
const multer = require("multer");
const {mergepdfs} = require("./merge");
const upload = multer({ dest: "uploads/" });
app.use('/static', express.static("public"));
const port = 3000;

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname,"templates/index.html"));
});
  
app.post(
  "/merge",
  upload.array("pdfs", 12),
    async (req, res, next) => {
      console.log(req.files)
      console.log(req.files.length);

  
        if (req.files.length == 1) {
          await mergepdfs(
              path.join(__dirname, req.files[0].path)
            );
        } else if (req.files.length == 2) {
          await mergepdfs(
              path.join(__dirname, req.files[0].path),
              path.join(__dirname, req.files[1].path)
            );
        } else if (req.files.length == 3) {
          await mergepdfs(
              path.join(__dirname, req.files[0].path),
              path.join(__dirname, req.files[1].path),
              path.join(__dirname, req.files[2].path)
            );
        } else if (req.files.length == 4) {
         await mergepdfs(
              path.join(__dirname, req.files[0].path),
              path.join(__dirname, req.files[1].path),
              path.join(__dirname, req.files[2].path),
              path.join(__dirname, req.files[3].path)
            );
        } else if (req.files.length == 5) {
          await mergepdfs(
            path.join(__dirname, req.files[0].path),
            path.join(__dirname, req.files[1].path),
            path.join(__dirname, req.files[2].path),
            path.join(__dirname, req.files[3].path),
            path.join(__dirname, req.files[4].path)
          );
        } else if (req.files.length == 6) {
         await mergepdfs(
           path.join(__dirname, req.files[0].path),
           path.join(__dirname, req.files[1].path),
           path.join(__dirname, req.files[2].path),
           path.join(__dirname, req.files[3].path),
           path.join(__dirname, req.files[4].path),
           path.join(__dirname, req.files[5].path)
         );
        } else if (req.files.length == 7) {
         await mergepdfs(
           path.join(__dirname, req.files[0].path),
           path.join(__dirname, req.files[1].path),
           path.join(__dirname, req.files[2].path),
           path.join(__dirname, req.files[3].path),
           path.join(__dirname, req.files[4].path),
           path.join(__dirname, req.files[5].path),
           path.join(__dirname, req.files[6].path)
         );
        } else if (req.files.length == 8) {
         await mergepdfs(
           path.join(__dirname, req.files[0].path),
           path.join(__dirname, req.files[1].path),
           path.join(__dirname, req.files[2].path),
           path.join(__dirname, req.files[3].path),
           path.join(__dirname, req.files[4].path),
           path.join(__dirname, req.files[5].path),
           path.join(__dirname, req.files[6].path),
           path.join(__dirname, req.files[7].path)
         );
        }
      



      // await mergepdfs(
      //     path.join(__dirname, req.files[0].path),
      //     path.join(__dirname, req.files[1].path),
      //     path.join(__dirname, req.files[2].path)
      //   );
      res.redirect(`http://localhost:3000/static/merged.pdf`)

      // res.send({data : req.files})
    // req.files is array of `photos` files
    // req.body will contain the text fields, if there were any
  }
);

app.listen(port, () => {
  console.log(`Example app listening on port http://localhost:${port}`);
}); 