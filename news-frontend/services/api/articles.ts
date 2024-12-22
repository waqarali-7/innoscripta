import api from "./axiosInstance";

// export const fetchArticles = async (
//   search: string,
//   page: number,
//   token: string,
//   filters: { date?: string; category?: string; source?: string }
// ) => {
//   const params = {
//     search,
//     page,
//     date: filters.date || undefined,
//     category: filters.category || undefined,
//     source: filters.source || undefined,
//   };

//   const response = await api.get("/articles", {
//     headers: { Authorization: `Bearer ${token}` },
//     params,
//   });
//   return response.data.data;
// };


interface ArticleFilters {
  search?: string;
  category?: string;
  source?: string;
  from_date?: string;
  to_date?: string;
  per_page?: number;
  page?: number;
}

export const fetchArticles = async (
  token: string,
  filters: ArticleFilters
) => {
  const { search, category, source, from_date, to_date, page = 1, per_page = 10 } = filters;

  const response = await api.get("/articles", {
    headers: { Authorization: `Bearer ${token}` },
    params: {
      search,
      category,
      source,
      from_date,
      to_date,
      page,
      per_page,
    },
  });

  return response.data.data;
};

export const fetchSingleArticle = async (id: string, token: string) => {
  const response = await api.get(`/articles/${id}`, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return response.data;
};
