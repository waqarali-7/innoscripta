import Link from "next/link";
import { useState } from "react";
import { Article } from "@/types/article";

const ArticleCard = ({ article }: { article: Article }) => {
  const [imageError, setImageError] = useState(false);

  return (
    <Link key={article.id} href={`/articles/${article.id}`}>
      <div className="border p-4 rounded-lg shadow cursor-pointer hover:shadow-lg">
        {/* Fixed-height Image Container */}
        <div className="w-full h-48 bg-gray-200 rounded flex items-center justify-center overflow-hidden">
          {!imageError && article.url_to_image ? (
            <img
              src={article.url_to_image}
              alt={article.title}
              className="w-full h-full object-cover"
              onError={() => setImageError(true)}
            />
          ) : (
            // Placeholder for missing image
            <span className="text-gray-500">No Image Available</span>
          )}
        </div>
        <h2 className="text-lg font-bold mt-4">{article.title}</h2>
        <p className="text-sm text-gray-600">{article.description}</p>
      </div>
    </Link>
  );
};

export default ArticleCard;
