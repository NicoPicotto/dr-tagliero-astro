import { defineConfig } from "tinacms";

// Your hosting provider likely exposes this as an environment variable
const branch =
   process.env.GITHUB_BRANCH ||
   process.env.VERCEL_GIT_COMMIT_REF ||
   process.env.HEAD ||
   "main";

export default defineConfig({
   branch,

  clientId: process.env.TINA_CLIENT_ID!,
token: process.env.TINA_TOKEN!,

   build: {
      outputFolder: "admin",
      publicFolder: "public",
   },
   media: {
      tina: {
         mediaRoot: "",
         publicFolder: "public",
      },
   },
   // See docs on content modeling for more info on how to setup new content models: https://tina.io/docs/schema/
   schema: {
      collections: [
         {
            name: "blog",
            label: "Posts",
            path: "/src/content/blog",
            fields: [
               {
                  type: "string",
                  name: "title",
                  label: "Titulo",
                  isTitle: true,
                  required: true,
               },
               {
                  type: "string",
                  name: "description",
                  label: "Descripcion",
                  required: true,
               },
               {
                  type: "string",
                  name: "category",
                  label: "Categoria",
                  required: true,
               },
               {
                  type: "datetime",
                  name: "posted",
                  label: "Fecha de publicación",
                  required: true,
               },
               {
                  type: "image",
                  label: "Imagen",
                  name: "imgSrc",
                  required: true,
               },
               {
                  type: "rich-text",
                  name: "body",
                  label: "Contenido",
                  isBody: true,
               },
            ],
         },
      ],
   },
});
