<?php

class ProductController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get all products with pagination and filters
     */
    public function index($params = []) {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? min((int)$_GET['limit'], MAX_PAGE_SIZE) : DEFAULT_PAGE_SIZE;
            $offset = ($page - 1) * $limit;
            
            $category = $_GET['category'] ?? null;
            $search = $_GET['search'] ?? null;
            $brand = $_GET['brand'] ?? null;
            $minPrice = $_GET['min_price'] ?? null;
            $maxPrice = $_GET['max_price'] ?? null;

            // Build query
            $where = ['p.is_active = 1'];
            $queryParams = [];

            if ($category) {
                $where[] = 'c.slug = :category';
                $queryParams['category'] = $category;
            }

            if ($brand) {
                $where[] = 'b.slug = :brand';
                $queryParams['brand'] = $brand;
            }

            if ($search) {
                $where[] = '(p.name LIKE :search OR p.description LIKE :search)';
                $queryParams['search'] = '%' . $search . '%';
            }

            if ($minPrice !== null) {
                $where[] = 'p.base_price >= :min_price';
                $queryParams['min_price'] = $minPrice;
            }

            if ($maxPrice !== null) {
                $where[] = 'p.base_price <= :max_price';
                $queryParams['max_price'] = $maxPrice;
            }

            $whereClause = implode(' AND ', $where);

            // Get total count
            $countSql = "SELECT COUNT(*) as total 
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.id 
                        LEFT JOIN brands b ON p.brand_id = b.id 
                        WHERE $whereClause";
            $totalResult = $this->db->fetchOne($countSql, $queryParams);
            $total = $totalResult['total'];

            // Get products
            $sql = "SELECT 
                        p.*,
                        c.name as category_name,
                        c.slug as category_slug,
                        b.name as brand_name,
                        b.slug as brand_slug,
                        (SELECT image_url FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
                        (SELECT AVG(rating) FROM product_reviews WHERE product_id = p.id AND is_approved = 1) as avg_rating,
                        (SELECT COUNT(*) FROM product_reviews WHERE product_id = p.id AND is_approved = 1) as review_count
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    LEFT JOIN brands b ON p.brand_id = b.id 
                    WHERE $whereClause
                    ORDER BY p.created_at DESC
                    LIMIT :limit OFFSET :offset";

            $queryParams['limit'] = $limit;
            $queryParams['offset'] = $offset;

            $products = $this->db->fetchAll($sql, $queryParams);

            echo json_encode([
                'success' => true,
                'data' => $products,
                'pagination' => [
                    'total' => (int)$total,
                    'page' => $page,
                    'limit' => $limit,
                    'pages' => ceil($total / $limit)
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get single product by slug
     */
    public function show($params) {
        try {
            $slug = $params['slug'];

            $sql = "SELECT 
                        p.*,
                        c.name as category_name,
                        c.slug as category_slug,
                        b.name as brand_name,
                        b.slug as brand_slug,
                        b.logo_url as brand_logo
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    LEFT JOIN brands b ON p.brand_id = b.id 
                    WHERE p.slug = :slug AND p.is_active = 1";

            $product = $this->db->fetchOne($sql, ['slug' => $slug]);

            if (!$product) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Product not found'
                ]);
                return;
            }

            // Get images
            $imagesSql = "SELECT * FROM product_images WHERE product_id = :product_id ORDER BY display_order, is_primary DESC";
            $product['images'] = $this->db->fetchAll($imagesSql, ['product_id' => $product['id']]);

            // Get variants if exists
            if ($product['has_variants']) {
                $variantsSql = "SELECT * FROM product_variants WHERE product_id = :product_id AND is_active = 1 ORDER BY name";
                $product['variants'] = $this->db->fetchAll($variantsSql, ['product_id' => $product['id']]);
            }

            // Get reviews
            $reviewsSql = "SELECT 
                            pr.*,
                            u.full_name as user_name
                          FROM product_reviews pr
                          JOIN users u ON pr.user_id = u.id
                          WHERE pr.product_id = :product_id AND pr.is_approved = 1
                          ORDER BY pr.created_at DESC
                          LIMIT 10";
            $product['reviews'] = $this->db->fetchAll($reviewsSql, ['product_id' => $product['id']]);

            echo json_encode([
                'success' => true,
                'data' => $product
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get all categories
     */
    public function categories($params = []) {
        try {
            $sql = "SELECT 
                        c.*,
                        COUNT(p.id) as product_count
                    FROM categories c
                    LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
                    WHERE c.is_active = 1
                    GROUP BY c.id
                    ORDER BY c.display_order, c.name";

            $categories = $this->db->fetchAll($sql);

            echo json_encode([
                'success' => true,
                'data' => $categories
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create new product (admin only)
     */
    public function store($params = []) {
        // TODO: Add authentication middleware
        // TODO: Add validation
        // TODO: Implement product creation
        
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Not implemented yet'
        ]);
    }

    /**
     * Update product (admin only)
     */
    public function update($params) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Not implemented yet'
        ]);
    }

    /**
     * Delete product (admin only)
     */
    public function destroy($params) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Not implemented yet'
        ]);
    }
}
