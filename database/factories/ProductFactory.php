<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement($this->names()),
            'preview' => $this->preview(),
            'code' => $this->code(),
            'price' => mt_rand(100, 9999) / 100,
            'category_id' => mt_rand(5, 16)
        ];
    }

    protected function preview(): array
    {
        return [
            'mobile' => [
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
            ],
            'desktop' => [
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
            ]
        ];
    }

    protected function code()
    {
        return [
            'html' => file_get_contents(public_path('storage/codes/html/' . mt_rand(1, 3))),
            'vue' => file_get_contents(public_path('storage/codes/vue/' . mt_rand(1, 3))),
            'react' => file_get_contents(public_path('storage/codes/react/' . mt_rand(1, 3))),
        ];
    }

    protected function names(): array
    {
        return [
            "Layout 布局",
            "Color 色彩",
            "Border 边框",
            "Icon 图标",
            "Button 按钮",
            "Link 文字链接",
            "Radio 单选框",
            "Input 输入框",
            "Select 选择器",
            "Switch 开关",
            "Slider 滑块",
            "Upload 上传",
            "Rate 评分",
            "Form 表单",
            "Table 表格",
            "Tag 标签",
            "Tree 树形控件",
            "Badge 标记",
            "Avatar 头像",
            "Alert 警告",
            "Loading 加载",
            "Message 消息",
            "Tabs 标签页",
            "Steps 步骤条",
            "Dialog 对话框",
            "Tooltip 提示",
            "Card 卡片",
            "Carousel 走马灯",
            "Collapse 折叠面板",
            "Timeline 时间线",
            "Divider 分割线",
            "Calendar 日历",
            "Image 图片",
            "Drawer 抽屉",
        ];
    }
}
