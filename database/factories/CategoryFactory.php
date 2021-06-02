<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $sort = 1;
        return [
            'name' => $this->faker->randomElement($this->names()),
            'sort' => $sort++,
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
