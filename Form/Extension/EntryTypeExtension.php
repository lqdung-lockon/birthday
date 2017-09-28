<?php

namespace Plugin\BirthdayEntry\Form\Extension;

use Eccube\Annotation\Inject;
use Eccube\Form\Type\Front\EntryType;
use Pimple\Container;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EntryTypeExtension
 * @package Plugin\BirthdayEntry\Form\Extension
 */
class EntryTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    public $appConfig;

    /**
     * EntryTypeExtension constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->appConfig = $app['config'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 職業を必須項目に変更するサンプル
        $builder->remove('birth');
        $builder->add('birth', BirthdayType::class, array(
            'required' => true,
            'input' => 'datetime',
            'years' => range(date('Y'), date('Y') - $this->appConfig['birth_max']),
            'widget' => 'choice',
            'format' => 'yyyy/MM/dd',
            'placeholder' => array('year' => '----', 'month' => '--', 'day' => '--'),
            'constraints' => array(
                new Assert\LessThanOrEqual(array(
                    'value' => date('Y-m-d'),
                    'message' => 'form.type.select.selectisfuturedate',
                )),
                new Assert\NotBlank(),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return EntryType::class;
    }
}
