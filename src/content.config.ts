// Import utilities from `astro:content`
import { z, defineCollection } from "astro:content";
// Define a `loader` and `schema` for each collection
const blog = defineCollection({
   schema: z.object({
      title: z.string(),
      description: z.string(),
      category: z.string(),
      posted: z.date(),
      imgSrc: z.string(), // equivale a `imgSrc` en Tina
   }),
});
// Export a single `collections` object to register your collection(s)
export const collections = { blog };
