import React from "react";

interface PaginationProps {
  currentPage: number;
  totalPages: number;
  totalArticles: number;
  onPageChange: (page: number) => void;
}

const Pagination = ({
  currentPage,
  totalPages,
  totalArticles,
  onPageChange,
}: PaginationProps) => {
  return (
    <div className="flex justify-center items-center gap-2 mt-6">
      {/* First Page */}
      <button
        disabled={currentPage === 1}
        onClick={() => onPageChange(1)}
        className="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        First
      </button>

      {/* Previous Page */}
      <button
        disabled={currentPage === 1}
        onClick={() => onPageChange(currentPage - 1)}
        className="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        Previous
      </button>

      {/* Page Info */}
      <p className="text-gray-700 px-4">
        Page <strong>{currentPage}</strong> of <strong>{totalPages}</strong> | Total:{" "}
        <strong>{totalArticles}</strong>
      </p>

      {/* Next Page */}
      <button
        disabled={currentPage === totalPages}
        onClick={() => onPageChange(currentPage + 1)}
        className="px-3 py-2 bg-blue-500 text-white rounded disabled:opacity-50"
      >
        Next
      </button>

      {/* Last Page */}
      <button
        disabled={currentPage === totalPages}
        onClick={() => onPageChange(totalPages)}
        className="px-3 py-2 bg-blue-500 text-white rounded disabled:opacity-50"
      >
        Last
      </button>
    </div>
  );
};

export default Pagination;
