<?php
/**
 * Pagination Helper
 * Provides pagination functionality for list views
 */

class Pagination
{
    /**
     * Calculate pagination values
     * @param int $totalItems Total number of items
     * @param int $itemsPerPage Items per page
     * @param int $currentPage Current page number
     * @return array Pagination data
     */
    public static function calculate(int $totalItems, int $itemsPerPage = 20, int $currentPage = 1): array
    {
        $totalPages = max(1, ceil($totalItems / $itemsPerPage));
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $itemsPerPage;

        return [
            'total_items' => $totalItems,
            'items_per_page' => $itemsPerPage,
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'offset' => $offset,
            'has_prev' => $currentPage > 1,
            'has_next' => $currentPage < $totalPages,
            'prev_page' => max(1, $currentPage - 1),
            'next_page' => min($totalPages, $currentPage + 1),
        ];
    }

    /**
     * Render pagination HTML
     * @param array $pagination Pagination data from calculate()
     * @param string $baseUrl Base URL for pagination links
     * @param array $queryParams Additional query parameters
     * @return string HTML pagination links
     */
    public static function render(array $pagination, string $baseUrl, array $queryParams = []): string
    {
        if ($pagination['total_pages'] <= 1) {
            return '';
        }

        $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

        // Previous button
        $prevDisabled = !$pagination['has_prev'] ? ' disabled' : '';
        $prevUrl = self::buildUrl($baseUrl, $pagination['prev_page'], $queryParams);
        $html .= '<li class="page-item' . $prevDisabled . '">';
        $html .= '<a class="page-link" href="' . htmlspecialchars($prevUrl) . '" aria-label="Previous">';
        $html .= '<span aria-hidden="true">&laquo; Previous</span></a></li>';

        // Page numbers (show max 7 pages)
        $start = max(1, $pagination['current_page'] - 3);
        $end = min($pagination['total_pages'], $pagination['current_page'] + 3);

        // First page
        if ($start > 1) {
            $url = self::buildUrl($baseUrl, 1, $queryParams);
            $html .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($url) . '">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Page range
        for ($i = $start; $i <= $end; $i++) {
            $active = $i === $pagination['current_page'] ? ' active' : '';
            $url = self::buildUrl($baseUrl, $i, $queryParams);
            $html .= '<li class="page-item' . $active . '">';
            $html .= '<a class="page-link" href="' . htmlspecialchars($url) . '">' . $i . '</a></li>';
        }

        // Last page
        if ($end < $pagination['total_pages']) {
            if ($end < $pagination['total_pages'] - 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $url = self::buildUrl($baseUrl, $pagination['total_pages'], $queryParams);
            $html .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($url) . '">' . $pagination['total_pages'] . '</a></li>';
        }

        // Next button
        $nextDisabled = !$pagination['has_next'] ? ' disabled' : '';
        $nextUrl = self::buildUrl($baseUrl, $pagination['next_page'], $queryParams);
        $html .= '<li class="page-item' . $nextDisabled . '">';
        $html .= '<a class="page-link" href="' . htmlspecialchars($nextUrl) . '" aria-label="Next">';
        $html .= '<span aria-hidden="true">Next &raquo;</span></a></li>';

        $html .= '</ul></nav>';

        return $html;
    }

    /**
     * Build URL with query parameters
     * @param string $baseUrl Base URL
     * @param int $page Page number
     * @param array $queryParams Additional query parameters
     * @return string Complete URL
     */
    private static function buildUrl(string $baseUrl, int $page, array $queryParams): string
    {
        $queryParams['page'] = $page;
        $query = http_build_query($queryParams);
        return $baseUrl . '?' . $query;
    }
}
