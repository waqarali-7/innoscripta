"use client";

import { useQuery } from "@tanstack/react-query";
import { useAuth } from "@/services/context/AuthContext";
import { fetchArticles } from "@/services/api/articles";
import { useState } from "react";
import ArticleCard from "@/components/ArticleCard";
import ProtectedRoute from "@/components/ProtectedRoute";
import { Article } from "@/types/article";

const Articles = () => {
  const { token } = useAuth();

  const [filters, setFilters] = useState({
    search: "",
    category: "",
    source: "",
    from_date: "",
    to_date: "",
  });
  const [appliedFilters, setAppliedFilters] = useState({ ...filters });
  const [page, setPage] = useState(1);

  // Query runs only when filters or page change
  const { data, isLoading, isError } = useQuery({
    queryKey: ["articles", appliedFilters, page],
    queryFn: () => fetchArticles(token as string, { ...appliedFilters, page }),
    enabled: !!token,
  });

  const articles = data?.data || [];
  const totalPages = data?.last_page || 1;

  const handleFilterChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFilters((prev) => ({ ...prev, [name]: value }));
  };

  const handleApplyFilters = () => {
    setAppliedFilters(filters);
    setPage(1); // Reset to page 1 on new filters
  };

  const resetFilters = () => {
    const resetValues = { search: "", category: "", source: "", from_date: "", to_date: "" };
    setFilters(resetValues);
    setAppliedFilters(resetValues);
    setPage(1);
  };

  return (
    <ProtectedRoute>
      <div className="container mx-auto p-4">
        <h1 className="text-2xl font-bold mb-4">Articles</h1>

        {/* Filters */}
        <div className="mb-4 space-y-2">
          {/* Search Field */}
          <input
            type="text"
            placeholder="Search articles..."
            name="search"
            value={filters.search}
            onChange={handleFilterChange}
            className="border p-2 rounded w-full"
          />

          {/* Text Fields for Category and Source */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input
              type="text"
              placeholder="Category (e.g., Technology)"
              name="category"
              value={filters.category}
              onChange={handleFilterChange}
              className="border p-2 rounded"
            />

            <input
              type="text"
              placeholder="Source (e.g., The Guardian)"
              name="source"
              value={filters.source}
              onChange={handleFilterChange}
              className="border p-2 rounded"
            />

            {/* Date Range */}
            <div className="flex gap-2">
              <input
                type="date"
                name="from_date"
                value={filters.from_date}
                onChange={handleFilterChange}
                className="border p-2 rounded w-full"
              />
              <input
                type="date"
                name="to_date"
                value={filters.to_date}
                onChange={handleFilterChange}
                className="border p-2 rounded w-full"
              />
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex gap-4 mt-2">
            <button
              onClick={handleApplyFilters}
              className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Apply Filters
            </button>
            <button
              onClick={resetFilters}
              className="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
            >
              Reset Filters
            </button>
          </div>
        </div>

        {/* Article List */}
        {isLoading && <p>Loading...</p>}
        {isError && <p>Failed to load articles</p>}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {articles?.map((article: Article) => (
            <ArticleCard key={article.id} article={article} />
          ))}
        </div>

        {/* Pagination */}
        <div className="flex justify-center items-center gap-2 mt-6">
          <button
            disabled={page === 1}
            onClick={() => setPage(1)}
            className="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
          >
            First
          </button>
          <button
            disabled={page === 1}
            onClick={() => setPage((prev) => Math.max(prev - 1, 1))}
            className="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
          >
            Previous
          </button>

          <p className="text-gray-700 px-4">
            Page <strong>{page}</strong> of <strong>{totalPages}</strong>
          </p>

          <button
            disabled={page === totalPages}
            onClick={() => setPage((prev) => prev + 1)}
            className="px-3 py-2 bg-blue-500 text-white rounded disabled:opacity-50"
          >
            Next
          </button>
          <button
            disabled={page === totalPages}
            onClick={() => setPage(totalPages)}
            className="px-3 py-2 bg-blue-500 text-white rounded disabled:opacity-50"
          >
            Last
          </button>
        </div>
      </div>
    </ProtectedRoute>
  );
};

export default Articles;
